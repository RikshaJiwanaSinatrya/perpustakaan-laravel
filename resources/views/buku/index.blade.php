<x-layouts.app :title="'Katalog Buku'">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-stone-900">Katalog Buku</h1>
        <p class="mt-1 text-stone-500">Cari judul, penulis, atau filter berdasarkan kategori.</p>
    </div>

    <form method="GET" action="/buku" class="mb-8 rounded-2xl border border-stone-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row">
            <div class="relative flex-1">
                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">🔍</span>
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul, penulis, atau penerbit…"
                       class="w-full rounded-xl border border-stone-300 py-3 pl-11 pr-4 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
            </div>
            <select name="kategori"
                    class="rounded-xl border border-stone-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                <option value="">Semua Kategori</option>
                @foreach ($kategoriList as $kat)
                    <option value="{{ $kat }}" @selected($kategori === $kat)>{{ $kat }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white hover:bg-emerald-700">Cari</button>
            @if ($q !== '' || $kategori !== '')
                <a href="/buku" class="rounded-xl border border-stone-300 px-4 py-3 text-sm font-medium text-stone-600 hover:bg-stone-100">Reset</a>
            @endif
        </div>
        @if ($q !== '' || $kategori !== '')
            <p class="mt-3 text-sm text-stone-500">
                Menampilkan {{ count($buku) }} buku
                @if ($q !== '') untuk pencarian "<strong>{{ $q }}</strong>" @endif
                @if ($kategori !== '') pada kategori "<strong>{{ $kategori }}</strong>" @endif
            </p>
        @endif
    </form>

    @if (count($buku) === 0)
        <div class="rounded-2xl border border-dashed border-stone-300 bg-white p-16 text-center">
            <p class="text-4xl">📖</p>
            <p class="mt-3 font-semibold text-stone-700">Buku tidak ditemukan</p>
            <p class="text-sm text-stone-500">Coba kata kunci lain atau ubah filter kategori.</p>
            <a href="/buku" class="mt-4 inline-block rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">Lihat Semua Buku</a>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($buku as $item)
                <x-buku-card :buku="$item" />
            @endforeach
        </div>
    @endif
</x-layouts.app>
