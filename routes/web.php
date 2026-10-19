<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/mock.php';

/*
|--------------------------------------------------------------------------
| Publik
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $buku = mock_books_state();
    $populer = array_slice($buku, 0, 6);
    $totalBuku = count($buku);
    $totalJudul = $totalBuku;
    $totalKopi = array_sum(array_column($buku, 'stok'));
    $totalAnggota = count(array_filter(mock_pengguna_state(), fn ($u) => $u['role'] === 'anggota'));
    $dipinjam = count(array_filter(mock_peminjaman_state(), fn ($l) => $l['status'] === 'dipinjam'));

    return view('home', compact('populer', 'totalJudul', 'totalKopi', 'totalAnggota', 'dipinjam'));
});

Route::get('/buku', function () {
    $q = trim((string) request('q', ''));
    $kategori = (string) request('kategori', '');

    $buku = mock_books_state();

    if ($q !== '') {
        $buku = array_values(array_filter($buku, function ($b) use ($q) {
            return stripos($b['judul'], $q) !== false
                || stripos($b['penulis'], $q) !== false
                || stripos($b['penerbit'], $q) !== false;
        }));
    }

    if ($kategori !== '') {
        $buku = array_values(array_filter($buku, fn ($b) => $b['kategori'] === $kategori));
    }

    return view('buku.index', [
        'buku' => $buku,
        'kategoriList' => mock_kategoris(),
        'q' => $q,
        'kategori' => $kategori,
    ]);
});

Route::get('/buku/{id}', function (int $id) {
    $buku = mock_buku_by_id($id);

    if (! $buku) {
        abort(404);
    }

    return view('buku.show', [
        'buku' => $buku,
        'tersedia' => mock_stok_tersedia($buku),
    ]);
})->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Auth mock (session saja)
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    if (current_user()) {
        return redirect(current_user()['role'] === 'admin' ? '/admin' : '/pinjaman');
    }

    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    $email = trim((string) request('email'));
    $password = (string) request('password');

    $user = null;
    foreach (mock_pengguna_state() as $u) {
        if (strcasecmp($u['email'], $email) === 0 && $u['password'] === $password) {
            $user = $u;
            break;
        }
    }

    if (! $user) {
        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    session(['mock_user' => $user]);

    return redirect($user['role'] === 'admin' ? '/admin' : '/pinjaman')
        ->with('sukses', 'Selamat datang, '.$user['nama'].'!');
});

Route::get('/register', function () {
    if (current_user()) {
        return redirect('/');
    }

    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    request()->validate([
        'nama' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:100'],
        'password' => ['required', 'string', 'min:6'],
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
    ]);

    $email = trim((string) request('email'));
    $users = mock_pengguna_state();

    foreach ($users as $u) {
        if (strcasecmp($u['email'], $email) === 0) {
            return back()->withErrors(['email' => 'Email sudah terdaftar.'])->onlyInput('nama', 'email');
        }
    }

    $user = [
        'id' => mock_next_id($users),
        'nama' => trim((string) request('nama')),
        'email' => $email,
        'role' => 'anggota',
        'no_anggota' => 'AGT-'.str_pad((string) count(array_filter($users, fn ($u) => $u['role'] === 'anggota')) + 1, 4, '0', STR_PAD_LEFT),
        'bergabung' => date('Y-m-d'),
        'password' => (string) request('password'),
    ];

    $users[] = $user;
    mock_save_pengguna($users);
    session(['mock_user' => $user]);

    return redirect('/pinjaman')->with('sukses', 'Registrasi berhasil. Selamat datang, '.$user['nama'].'!');
});

Route::post('/logout', function () {
    session()->forget('mock_user');

    return redirect('/')->with('sukses', 'Anda telah keluar.');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Anggota — peminjaman
|--------------------------------------------------------------------------
*/

Route::get('/pinjaman', function () {
    $user = current_user();

    if (! $user) {
        return redirect('/login');
    }

    $pinjaman = array_values(array_filter(
        mock_peminjaman_state(),
        fn ($l) => $l['pengguna_id'] === $user['id']
    ));
    usort($pinjaman, fn ($a, $b) => $b['id'] <=> $a['id']);

    return view('member.pinjaman', ['pinjaman' => $pinjaman]);
})->name('pinjaman');

Route::post('/pinjaman/{id}', function (int $id) {
    $user = current_user();

    if (! $user) {
        return redirect('/login');
    }

    $buku = mock_buku_by_id($id);

    if (! $buku) {
        abort(404);
    }

    if (mock_stok_tersedia($buku) <= 0) {
        return back()->with('galat', 'Stok "'.$buku['judul'].'" sedang habis.');
    }

    $loans = mock_peminjaman_state();

    foreach ($loans as $loan) {
        if ($loan['buku_id'] === $id && $loan['pengguna_id'] === $user['id'] && $loan['status'] === 'dipinjam') {
            return back()->with('galat', 'Anda sudah meminjam buku ini.');
        }
    }

    $loans[] = [
        'id' => mock_next_id($loans),
        'buku_id' => $id,
        'pengguna_id' => $user['id'],
        'tanggal_pinjam' => date('Y-m-d'),
        'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
        'status' => 'dipinjam',
    ];
    mock_save_peminjaman($loans);

    return redirect('/pinjaman')->with('sukses', 'Berhasil meminjam "'.$buku['judul'].'". Kembali tanggal '.mock_tanggal(date('Y-m-d', strtotime('+7 days'))).'.');
})->where('id', '[0-9]+')->name('pinjam');

Route::post('/pinjaman/{id}/kembali', function (int $id) {
    $user = current_user();

    if (! $user) {
        return redirect('/login');
    }

    $loans = mock_peminjaman_state();
    $ditemukan = false;

    foreach ($loans as $i => $loan) {
        if ($loan['id'] === $id && $loan['pengguna_id'] === $user['id'] && $loan['status'] === 'dipinjam') {
            $loans[$i]['status'] = 'dikembalikan';
            $ditemukan = true;
            break;
        }
    }

    if (! $ditemukan) {
        return back()->with('galat', 'Peminjaman tidak ditemukan.');
    }

    mock_save_peminjaman($loans);

    return back()->with('sukses', 'Buku berhasil dikembalikan.');
})->where('id', '[0-9]+')->name('kembali');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::get('/admin', function () {
    $user = current_user();

    if (! $user) {
        return redirect('/login');
    }
    if ($user['role'] !== 'admin') {
        return redirect('/pinjaman')->with('galat', 'Halaman ini hanya untuk admin.');
    }

    $buku = mock_books_state();
    $loans = mock_peminjaman_state();
    $anggota = array_filter(mock_pengguna_state(), fn ($u) => $u['role'] === 'anggota');

    $terbaru = array_slice(array_reverse($loans), 0, 6);

    return view('admin.dashboard', [
        'totalJudul' => count($buku),
        'totalKopi' => array_sum(array_column($buku, 'stok')),
        'totalAnggota' => count($anggota),
        'dipinjam' => count(array_filter($loans, fn ($l) => $l['status'] === 'dipinjam')),
        'terlambat' => count(array_filter($loans, fn ($l) => $l['status'] === 'terlambat')),
        'dikembalikan' => count(array_filter($loans, fn ($l) => $l['status'] === 'dikembalikan')),
        'terbaru' => $terbaru,
        'kategoriStats' => count(array_unique(array_column($buku, 'kategori'))),
    ]);
})->name('admin');

Route::get('/admin/buku', function () {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    return view('admin.buku.index', ['buku' => mock_books_state()]);
})->name('admin.buku');

Route::get('/admin/buku/create', function () {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    return view('admin.buku.form', ['buku' => null, 'kategoriList' => mock_kategoris()]);
})->name('admin.buku.create');

Route::post('/admin/buku', function () {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    request()->validate([
        'judul' => ['required', 'string', 'max:150'],
        'penulis' => ['required', 'string', 'max:100'],
        'penerbit' => ['required', 'string', 'max:100'],
        'tahun' => ['required', 'integer', 'min:1900', 'max:2030'],
        'kategori' => ['required', 'string', 'max:50'],
        'stok' => ['required', 'integer', 'min:0'],
        'isbn' => ['nullable', 'string', 'max:30'],
        'deskripsi' => ['nullable', 'string', 'max:1000'],
    ], [
        'judul.required' => 'Judul wajib diisi.',
        'penulis.required' => 'Penulis wajib diisi.',
        'penerbit.required' => 'Penerbit wajib diisi.',
        'tahun.required' => 'Tahun terbit wajib diisi.',
        'kategori.required' => 'Kategori wajib diisi.',
        'stok.required' => 'Stok wajib diisi.',
        'stok.min' => 'Stok tidak boleh negatif.',
    ]);

    $warnaList = [
        'from-emerald-500 to-teal-700', 'from-amber-500 to-orange-700', 'from-sky-500 to-blue-700',
        'from-violet-500 to-purple-700', 'from-rose-500 to-pink-700', 'from-cyan-500 to-sky-700',
        'from-lime-500 to-green-700', 'from-red-500 to-rose-700',
    ];

    $books = mock_books_state();
    $books[] = [
        'id' => mock_next_id($books),
        'judul' => trim((string) request('judul')),
        'penulis' => trim((string) request('penulis')),
        'penerbit' => trim((string) request('penerbit')),
        'tahun' => (int) request('tahun'),
        'kategori' => trim((string) request('kategori')),
        'stok' => (int) request('stok'),
        'isbn' => trim((string) request('isbn', '-')),
        'deskripsi' => trim((string) request('deskripsi', '')),
        'warna' => $warnaList[array_rand($warnaList)],
    ];
    mock_save_books($books);

    return redirect('/admin/buku')->with('sukses', 'Buku "'.request('judul').'" berhasil ditambahkan.');
})->name('admin.buku.store');

Route::get('/admin/buku/{id}/edit', function (int $id) {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    $buku = mock_buku_by_id($id);

    if (! $buku) {
        abort(404);
    }

    return view('admin.buku.form', ['buku' => $buku, 'kategoriList' => mock_kategoris()]);
})->where('id', '[0-9]+')->name('admin.buku.edit');

Route::put('/admin/buku/{id}', function (int $id) {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    request()->validate([
        'judul' => ['required', 'string', 'max:150'],
        'penulis' => ['required', 'string', 'max:100'],
        'penerbit' => ['required', 'string', 'max:100'],
        'tahun' => ['required', 'integer', 'min:1900', 'max:2030'],
        'kategori' => ['required', 'string', 'max:50'],
        'stok' => ['required', 'integer', 'min:0'],
        'isbn' => ['nullable', 'string', 'max:30'],
        'deskripsi' => ['nullable', 'string', 'max:1000'],
    ], [
        'judul.required' => 'Judul wajib diisi.',
        'penulis.required' => 'Penulis wajib diisi.',
        'penerbit.required' => 'Penerbit wajib diisi.',
        'tahun.required' => 'Tahun terbit wajib diisi.',
        'kategori.required' => 'Kategori wajib diisi.',
        'stok.required' => 'Stok wajib diisi.',
    ]);

    $books = mock_books_state();
    $ditemukan = false;

    foreach ($books as $i => $b) {
        if ($b['id'] === $id) {
            $books[$i] = array_merge($b, [
                'judul' => trim((string) request('judul')),
                'penulis' => trim((string) request('penulis')),
                'penerbit' => trim((string) request('penerbit')),
                'tahun' => (int) request('tahun'),
                'kategori' => trim((string) request('kategori')),
                'stok' => (int) request('stok'),
                'isbn' => trim((string) request('isbn', '-')),
                'deskripsi' => trim((string) request('deskripsi', '')),
            ]);
            $ditemukan = true;
            break;
        }
    }

    if (! $ditemukan) {
        abort(404);
    }

    mock_save_books($books);

    return redirect('/admin/buku')->with('sukses', 'Buku berhasil diperbarui.');
})->where('id', '[0-9]+')->name('admin.buku.update');

Route::delete('/admin/buku/{id}', function (int $id) {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    $books = mock_books_state();
    $books = array_values(array_filter($books, fn ($b) => $b['id'] !== $id));
    mock_save_books($books);

    return redirect('/admin/buku')->with('sukses', 'Buku berhasil dihapus.');
})->where('id', '[0-9]+')->name('admin.buku.destroy');

Route::get('/admin/peminjaman', function () {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    $loans = array_reverse(mock_peminjaman_state());

    return view('admin.peminjaman', ['pinjaman' => $loans]);
})->name('admin.peminjaman');

Route::post('/admin/peminjaman/{id}/kembali', function (int $id) {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    $loans = mock_peminjaman_state();

    foreach ($loans as $i => $loan) {
        if ($loan['id'] === $id && $loan['status'] === 'dipinjam') {
            $loans[$i]['status'] = 'dikembalikan';
            mock_save_peminjaman($loans);

            return back()->with('sukses', 'Peminjaman ditandai sudah dikembalikan.');
        }
    }

    return back()->with('galat', 'Peminjaman tidak ditemukan atau sudah dikembalikan.');
})->where('id', '[0-9]+')->name('admin.peminjaman.kembali');

Route::post('/admin/peminjaman/{id}/terlambat', function (int $id) {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    $loans = mock_peminjaman_state();

    foreach ($loans as $i => $loan) {
        if ($loan['id'] === $id && $loan['status'] === 'dipinjam') {
            $loans[$i]['status'] = 'terlambat';
            mock_save_peminjaman($loans);

            return back()->with('sukses', 'Peminjaman ditandai terlambat.');
        }
    }

    return back()->with('galat', 'Hanya peminjaman berstatus "Dipinjam" yang bisa ditandai terlambat.');
})->where('id', '[0-9]+')->name('admin.peminjaman.terlambat');

Route::get('/admin/anggota', function () {
    $user = current_user();

    if (! $user || $user['role'] !== 'admin') {
        return redirect('/login');
    }

    $anggota = array_values(array_filter(mock_pengguna_state(), fn ($u) => $u['role'] === 'anggota'));

    $denganPinjaman = [];
    foreach ($anggota as $a) {
        $dipinjam = count(array_filter(
            mock_peminjaman_state(),
            fn ($l) => $l['pengguna_id'] === $a['id'] && $l['status'] === 'dipinjam'
        ));
        $denganPinjaman[] = $a + ['dipinjam' => $dipinjam];
    }

    return view('admin.anggota', ['anggota' => $denganPinjaman]);
})->name('admin.anggota');
