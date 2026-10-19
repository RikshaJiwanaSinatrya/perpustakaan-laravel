<x-layouts.app :title="$buku['judul']">
    @php $user = \current_user(); @endphp

    <nav class="mb-6 text-sm text-stone-400">
        <a href="/" class="hover:text-emerald-700">Beranda</a> /
        <a href="/buku" class="hover:text-emerald-700">Katalog</a> /
        <span class="text-stone-600">{{ $buku['judul'] }}</span>
    </nav>

    <div class="grid gap-10 lg:grid-cols-[320px_1fr]">
        <div class="flex h-72 items-center justify-center rounded-3xl bg-gradient-to-br {{ $buku['warna'] }} shadow-xl sm:h-96">
            <span class="text-8xl font-black text-white/80">{{ strtoupper(substr($buku['judul'], 0, 1)) }}</span>
        </div>

        <div>
            <span class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">{{ $buku['kategori'] }}</span>
            <h1 class="mt-3 text-3xl font-black leading-tight text-stone-900 sm:text-4xl">{{ $buku['judul'] }}</h1>
            <p class="mt-2 text-lg text-stone-500">oleh {{ $buku['penulis'] }}</p>

            <dl class="mt-6 grid grid-cols-2 gap-4 rounded-2xl border border-stone-200 bg-white p-5 text-sm sm:grid-cols-4">
                <div>
                    <dt class="text-stone-400">Penerbit</dt>
                    <dd class="mt-0.5 font-semibold text-stone-800">{{ $buku['penerbit'] }}</dd>
                </div>
                <div>
                    <dt class="text-stone-400">Tahun</dt>
                    <dd class="mt-0.5 font-semibold text-stone-800">{{ $buku['tahun'] }}</dd>
                </div>
                <div>
                    <dt class="text-stone-400">ISBN</dt>
                    <dd class="mt-0.5 font-semibold text-stone-800">{{ $buku['isbn'] }}</dd>
                </div>
                <div>
                    <dt class="text-stone-400">Stok Tersedia</dt>
                    <dd class="mt-0.5 font-semibold {{ $tersedia > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $tersedia }} / {{ $buku['stok'] }}
                    </dd>
                </div>
            </dl>

            <div class="mt-6">
                <h2 class="font-bold text-stone-900">Sinopsis</h2>
                <p class="mt-2 leading-relaxed text-stone-600">{{ $buku['deskripsi'] }}</p>
            </div>

            <div class="mt-8">
                @if ($tersedia <= 0)
                    <div class="inline-block rounded-xl bg-rose-50 px-5 py-3 text-sm font-semibold text-rose-700">
                        Maaf, stok buku ini sedang habis.
                    </div>
                @elseif (!$user)
                    <a href="/login" class="inline-block rounded-xl bg-emerald-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg hover:bg-emerald-700">
                        Masuk untuk Meminjam
                    </a>
                    <p class="mt-2 text-sm text-stone-400">Anda perlu login sebagai anggota terlebih dahulu.</p>
                @elseif ($user['role'] === 'admin')
                    <a href="/admin/buku/{{ $buku['id'] }}/edit" class="inline-block rounded-xl border border-stone-300 px-8 py-3.5 text-sm font-bold text-stone-700 hover:bg-stone-100">
                        ✏️ Edit di Panel Admin
                    </a>
                @else
                    <form method="POST" action="/pinjaman/{{ $buku['id'] }}">
                        @csrf
                        <button type="submit" class="rounded-xl bg-emerald-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg hover:bg-emerald-700">
                            📚 Pinjam Buku Ini
                        </button>
                    </form>
                    <p class="mt-2 text-sm text-stone-400">Masa peminjaman 7 hari. Tenggat dihitung sejak hari ini.</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
