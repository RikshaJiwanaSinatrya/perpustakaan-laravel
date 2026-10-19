@props(['buku', 'tersedia' => null])

@php
    $sisa = $tersedia ?? \mock_stok_tersedia($buku);
@endphp

<a href="/buku/{{ $buku['id'] }}" {{ $attributes->merge(['class' => 'group block overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg']) }}>
    <div class="relative flex h-44 items-center justify-center bg-gradient-to-br {{ $buku['warna'] }}">
        <span class="text-5xl font-black text-white/80">{{ strtoupper(substr($buku['judul'], 0, 1)) }}</span>
        <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-0.5 text-xs font-semibold text-stone-700">{{ $buku['kategori'] }}</span>
        @if ($sisa <= 0)
            <span class="absolute right-3 top-3 rounded-full bg-rose-600 px-2.5 py-0.5 text-xs font-semibold text-white">Habis</span>
        @endif
    </div>
    <div class="space-y-1.5 p-4">
        <h3 class="line-clamp-2 font-semibold text-stone-800 group-hover:text-emerald-700">{{ $buku['judul'] }}</h3>
        <p class="text-sm text-stone-500">{{ $buku['penulis'] }}</p>
        <div class="flex items-center justify-between pt-1 text-xs text-stone-400">
            <span>{{ $buku['tahun'] }}</span>
            <span class="{{ $sisa > 0 ? 'text-emerald-600' : 'text-rose-500' }} font-medium">
                {{ $sisa > 0 ? $sisa . ' tersedia' : 'tidak tersedia' }}
            </span>
        </div>
    </div>
</a>
