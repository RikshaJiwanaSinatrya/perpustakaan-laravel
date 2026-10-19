<?php

/**
 * Data mock untuk frontend-only (tidak ada database).
 * State yang bisa berubah (buku, peminjaman, pengguna) disimpan di session.
 */
function mock_books(): array
{
    return [
        ['id' => 1, 'judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'penerbit' => 'Bentang', 'tahun' => 2005, 'kategori' => 'Fiksi', 'stok' => 5, 'isbn' => '978-979-1227-80-6', 'deskripsi' => 'Kisah perjuangan sepuluh anak sekolah muhammadiyah di Belitung memperjuangkan pendidikan dan mimpi di tengah keterbatasan.', 'warna' => 'from-emerald-500 to-teal-700'],
        ['id' => 2, 'judul' => 'Bumi Manusia', 'penulis' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'tahun' => 1980, 'kategori' => 'Fiksi', 'stok' => 4, 'isbn' => '978-979-3489-03-0', 'deskripsi' => 'Novel sejarah tentang Minke, seorang pribumi terpelajar yang berjuang melawan penindasan kolonial pada awal abad ke-20.', 'warna' => 'from-amber-500 to-orange-700'],
        ['id' => 3, 'judul' => 'Sapiens: Ringkasan Sejarah Umat Manusia', 'penulis' => 'Yuval Noah Harari', 'penerbit' => 'KPG', 'tahun' => 2011, 'kategori' => 'Non-Fiksi', 'stok' => 3, 'isbn' => '978-602-425-535-9', 'deskripsi' => 'Perjalanan panjang umat manusia dari sekawanan pemburu menjadi penguasa planet, lengkap dengan revolusi kognitif, pertanian, dan ilmu pengetahuan.', 'warna' => 'from-sky-500 to-blue-700'],
        ['id' => 4, 'judul' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'penerbit' => 'Kompas', 'tahun' => 2018, 'kategori' => 'Non-Fiksi', 'stok' => 6, 'isbn' => '978-602-412-518-1', 'deskripsi' => 'Pengantar filsafat Stoa yang praktis untuk mengelola emosi dan menjalani hidup yang lebih tenang di era modern.', 'warna' => 'from-violet-500 to-purple-700'],
        ['id' => 5, 'judul' => 'Negeri 5 Menara', 'penulis' => 'Ahmad Fuadi', 'penerbit' => 'Gramedia Pustaka Utama', 'tahun' => 2009, 'kategori' => 'Fiksi', 'stok' => 5, 'isbn' => '978-979-22-4655-5', 'deskripsi' => 'Kisah enam anak pesantren Gontor yang bermimpi besar dan saling memotivasi untuk meraih masa depan.', 'warna' => 'from-rose-500 to-pink-700'],
        ['id' => 6, 'judul' => 'Atomic Habits', 'penulis' => 'James Clear', 'penerbit' => 'Gramedia Pustaka Utama', 'tahun' => 2018, 'kategori' => 'Pengembangan Diri', 'stok' => 4, 'isbn' => '978-602-063-189-7', 'deskripsi' => 'Panduan membangun kebiasaan baik dan menghilangkan kebiasaan buruk melalui perubahan kecil yang konsisten.', 'warna' => 'from-yellow-400 to-amber-600'],
        ['id' => 7, 'judul' => 'Dilan: Dia Adalah Dilanku 1990', 'penulis' => 'Pidi Baiq', 'penerbit' => 'Republik', 'tahun' => 2014, 'kategori' => 'Fiksi', 'stok' => 7, 'isbn' => '978-602-391-059-2', 'deskripsi' => 'Kisah cinta remaja di Bandung tahun 1990 antara Milea dan Dilan, lewat surat-surat dan dialog yang khas.', 'warna' => 'from-cyan-500 to-sky-700'],
        ['id' => 8, 'judul' => 'Sejarah Indonesia Modern', 'penulis' => 'M.C. Ricklefs', 'penerbit' => 'Gramedia Pustaka Utama', 'tahun' => 1981, 'kategori' => 'Sejarah', 'stok' => 2, 'isbn' => '978-979-709-427-8', 'deskripsi' => 'Tinjauan komprehensif perkembangan Nusantara dari abad ke-17 hingga era kemerdekaan dan Orde Baru.', 'warna' => 'from-stone-500 to-neutral-700'],
        ['id' => 9, 'judul' => 'Pulang', 'penulis' => 'Tere Liye', 'penerbit' => 'Gramedia Pustaka Utama', 'tahun' => 2015, 'kategori' => 'Fiksi', 'stok' => 5, 'isbn' => '978-602-033-330-0', 'deskripsi' => 'Petualangan Biantara mencari saudara kembarnya melintasi berbagai negara dengan latar konflik dan misteri.', 'warna' => 'from-red-500 to-rose-700'],
        ['id' => 10, 'judul' => 'Buku Pintar Ekonomi', 'penulis' => 'Peter G. Peterson', 'penerbit' => 'Republika', 'tahun' => 2015, 'kategori' => 'Ekonomi', 'stok' => 3, 'isbn' => '978-602-226-860-0', 'deskripsi' => 'Pengantar ekonomi yang mudah dipahami: inflasi, pasar, kebijakan fiskal, dan isu ekonomi global.', 'warna' => 'from-lime-500 to-green-700'],
        ['id' => 11, 'judul' => 'Dilan 1991: Milea Adalah Dilanku', 'penulis' => 'Pidi Baiq', 'penerbit' => 'Republik', 'tahun' => 2015, 'kategori' => 'Fiksi', 'stok' => 6, 'isbn' => '978-602-391-327-4', 'deskripsi' => 'Kelanjutan kisah Dilan dan Milea saat hubungan mereka diuji oleh keadaan dan lingkungan sekitar.', 'warna' => 'from-teal-500 to-cyan-700'],
        ['id' => 12, 'judul' => 'Cantik Itu Luka', 'penulis' => 'Eka Kurniawan', 'penerbit' => 'Gramedia Pustaka Utama', 'tahun' => 2002, 'kategori' => 'Fiksi', 'stok' => 3, 'isbn' => '978-979-709-595-2', 'deskripsi' => 'Novel magis-realis tentang Dewi Ayu yang lahir dari kutukan dan menelusuri kisah cinta serta kutukan keluarganya.', 'warna' => 'from-fuchsia-500 to-purple-700'],
    ];
}

function mock_pengguna(): array
{
    return [
        ['id' => 1, 'nama' => 'Admin Perpus', 'email' => 'admin@perpus.id', 'role' => 'admin', 'no_anggota' => '-', 'bergabung' => '2024-01-01', 'password' => 'password'],
        ['id' => 2, 'nama' => 'Budi Santoso', 'email' => 'budi@contoh.id', 'role' => 'anggota', 'no_anggota' => 'AGT-0001', 'bergabung' => '2024-03-12', 'password' => 'password'],
        ['id' => 3, 'nama' => 'Siti Aminah', 'email' => 'siti@contoh.id', 'role' => 'anggota', 'no_anggota' => 'AGT-0002', 'bergabung' => '2024-05-20', 'password' => 'password'],
        ['id' => 4, 'nama' => 'Rizky Pratama', 'email' => 'rizky@contoh.id', 'role' => 'anggota', 'no_anggota' => 'AGT-0003', 'bergabung' => '2025-01-08', 'password' => 'password'],
        ['id' => 5, 'nama' => 'Dewi Lestari', 'email' => 'dewi@contoh.id', 'role' => 'anggota', 'no_anggota' => 'AGT-0004', 'bergabung' => '2025-06-15', 'password' => 'password'],
    ];
}

function mock_peminjaman(): array
{
    return [
        ['id' => 1, 'buku_id' => 2, 'pengguna_id' => 2, 'tanggal_pinjam' => '2026-10-01', 'tanggal_kembali' => '2026-10-08', 'status' => 'dikembalikan'],
        ['id' => 2, 'buku_id' => 6, 'pengguna_id' => 3, 'tanggal_pinjam' => '2026-10-05', 'tanggal_kembali' => '2026-10-12', 'status' => 'dipinjam'],
        ['id' => 3, 'buku_id' => 1, 'pengguna_id' => 4, 'tanggal_pinjam' => '2026-10-10', 'tanggal_kembali' => '2026-10-17', 'status' => 'dipinjam'],
        ['id' => 4, 'buku_id' => 9, 'pengguna_id' => 2, 'tanggal_pinjam' => '2026-10-12', 'tanggal_kembali' => '2026-10-19', 'status' => 'dipinjam'],
        ['id' => 5, 'buku_id' => 4, 'pengguna_id' => 5, 'tanggal_pinjam' => '2026-09-20', 'tanggal_kembali' => '2026-09-27', 'status' => 'dikembalikan'],
        ['id' => 6, 'buku_id' => 3, 'pengguna_id' => 3, 'tanggal_pinjam' => '2026-09-28', 'tanggal_kembali' => '2026-10-05', 'status' => 'terlambat'],
        ['id' => 7, 'buku_id' => 7, 'pengguna_id' => 5, 'tanggal_pinjam' => '2026-10-14', 'tanggal_kembali' => '2026-10-21', 'status' => 'dipinjam'],
    ];
}

function mock_books_state(): array
{
    if (! session()->has('mock_books')) {
        session(['mock_books' => mock_books()]);
    }

    return session('mock_books');
}

function mock_pengguna_state(): array
{
    if (! session()->has('mock_pengguna')) {
        session(['mock_pengguna' => mock_pengguna()]);
    }

    return session('mock_pengguna');
}

function mock_peminjaman_state(): array
{
    if (! session()->has('mock_peminjaman')) {
        session(['mock_peminjaman' => mock_peminjaman()]);
    }

    return session('mock_peminjaman');
}

function mock_save_books(array $books): void
{
    session(['mock_books' => $books]);
}

function mock_save_pengguna(array $users): void
{
    session(['mock_pengguna' => $users]);
}

function mock_save_peminjaman(array $loans): void
{
    session(['mock_peminjaman' => $loans]);
}

function current_user(): ?array
{
    return session('mock_user');
}

function mock_buku_by_id(int $id): ?array
{
    foreach (mock_books_state() as $buku) {
        if ($buku['id'] === $id) {
            return $buku;
        }
    }

    return null;
}

function mock_pengguna_by_id(int $id): ?array
{
    foreach (mock_pengguna_state() as $user) {
        if ($user['id'] === $id) {
            return $user;
        }
    }

    return null;
}

function mock_peminjaman_by_id(int $id): ?array
{
    foreach (mock_peminjaman_state() as $loan) {
        if ($loan['id'] === $id) {
            return $loan;
        }
    }

    return null;
}

function mock_jumlah_dipinjam(int $bukuId): int
{
    $count = 0;
    foreach (mock_peminjaman_state() as $loan) {
        if ($loan['buku_id'] === $bukuId && $loan['status'] === 'dipinjam') {
            $count++;
        }
    }

    return $count;
}

function mock_stok_tersedia(array $buku): int
{
    return max(0, $buku['stok'] - mock_jumlah_dipinjam($buku['id']));
}

function mock_next_id(array $items): int
{
    $max = 0;
    foreach ($items as $item) {
        $max = max($max, $item['id']);
    }

    return $max + 1;
}

function mock_kategoris(): array
{
    $kategori = [];
    foreach (mock_books_state() as $buku) {
        $kategori[$buku['kategori']] = true;
    }

    return array_keys($kategori);
}

function mock_status_label(string $status): string
{
    return match ($status) {
        'dipinjam' => 'Dipinjam',
        'dikembalikan' => 'Dikembalikan',
        'terlambat' => 'Terlambat',
        default => ucfirst($status),
    };
}

function mock_status_class(string $status): string
{
    return match ($status) {
        'dipinjam' => 'bg-sky-100 text-sky-700',
        'dikembalikan' => 'bg-emerald-100 text-emerald-700',
        'terlambat' => 'bg-rose-100 text-rose-700',
        default => 'bg-stone-100 text-stone-700',
    };
}

function mock_tanggal(string $tanggal): string
{
    $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $ts = strtotime($tanggal);

    return date('j', $ts).' '.$bulan[(int) date('n', $ts)].' '.date('Y', $ts);
}
