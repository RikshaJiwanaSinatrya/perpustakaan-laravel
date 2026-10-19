<x-layouts.app>
    @php $user = \current_user(); @endphp

    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 px-6 py-14 text-white sm:px-12">
        <div class="relative z-10 max-w-2xl">
            <p class="mb-3 inline-block rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-wide">Perpustakaan Digital</p>
            <h1 class="text-3xl font-black leading-tight sm:text-5xl">Temukan buku favoritmu,<br>pinjam tanpa antre.</h1>
            <p class="mt-4 max-w-xl text-emerald-100 sm:text-lg">Jelajahi katalog, cari judul atau penulis favorit, dan kelola peminjaman langsung dari browser.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="/buku" class="rounded-xl bg-white px-6 py-3 text-sm font-bold text-emerald-800 shadow-lg hover:bg-emerald-50">Jelajahi Katalog</a>
                @if (!$user)
                    <a href="/register" class="rounded-xl border border-white/40 px-6 py-3 text-sm font-bold text-white hover:bg-white/10">Daftar Jadi Anggota</a>
                @endif
            </div>
        </div>
        <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/10 blur-2xl"></div>
        <div class="pointer-events-none absolute -bottom-24 right-24 h-72 w-72 rounded-full bg-emerald-400/20 blur-2xl"></div>
    </section>

    <section class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
        @php
            $stats = [
                ['Judul Tersedia', $totalJudul, '📖'],
                ['Total Eksemplar', $totalKopi, '📚'],
                ['Anggota Terdaftar', $totalAnggota, '👥'],
                ['Sedang Dipinjam', $dipinjam, '🔄'],
            ];
        @endphp
        @foreach ($stats as [$label, $nilai, $ikon])
            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-lg">{{ $ikon }}</div>
                <p class="text-2xl font-black text-stone-900">{{ $nilai }}</p>
                <p class="text-sm text-stone-500">{{ $label }}</p>
            </div>
        @endforeach
    </section>

    <section class="mt-12">
        <div class="mb-5 flex items-end justify-between">
            <div>
                <h2 class="text-2xl font-black text-stone-900">Buku Pilihan</h2>
                <p class="text-sm text-stone-500">Beberapa judul yang lagi banyak diminati.</p>
            </div>
            <a href="/buku" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">Lihat semua →</a>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($populer as $buku)
                <x-buku-card :buku="$buku" />
            @endforeach
        </div>
    </section>

    <section class="mt-12 grid gap-5 sm:grid-cols-3">
        @php
            $keunggulan = [
                ['Cari Cepat', 'Temukan buku lewat judul, penulis, atau penerbit dalam hitungan detik.', '🔍'],
                ['Pinjam Online', 'Ajukan peminjaman dari rumah, tanpa perlu antre di loket perpustakaan.', '⚡'],
                ['Riwayat Jelas', 'Pantau buku yang sedang Anda pinjam beserta tenggat pengembaliannya.', '📋'],
            ];
        @endphp
        @foreach ($keunggulan as [$judul, $teks, $ikon])
            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-xl">{{ $ikon }}</div>
                <h3 class="font-bold text-stone-900">{{ $judul }}</h3>
                <p class="mt-1 text-sm text-stone-500">{{ $teks }}</p>
            </div>
        @endforeach
    </section>
</x-layouts.app>
