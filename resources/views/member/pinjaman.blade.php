<x-layouts.app :title="'Pinjaman Saya'">
    @php $user = \current_user(); @endphp

    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-3xl font-black text-stone-900">Pinjaman Saya</h1>
            <p class="mt-1 text-stone-500">Halo {{ $user['nama'] }} — no. anggota {{ $user['no_anggota'] }}</p>
        </div>
        <a href="/buku" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">+ Pinjam Buku Lain</a>
    </div>

    @if (count($pinjaman) === 0)
        <div class="rounded-2xl border border-dashed border-stone-300 bg-white p-16 text-center">
            <p class="text-4xl">📭</p>
            <p class="mt-3 font-semibold text-stone-700">Belum ada peminjaman</p>
            <p class="text-sm text-stone-500">Yuk mulai pinjam buku dari katalog.</p>
            <a href="/buku" class="mt-4 inline-block rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">Buka Katalog</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($pinjaman as $loan)
                @php $buku = \mock_buku_by_id($loan['buku_id']); @endphp
                <div class="flex flex-col gap-4 rounded-2xl border border-stone-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center">
                    <div class="flex h-20 w-16 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br {{ $buku['warna'] }} text-2xl font-black text-white/80">
                        {{ strtoupper(substr($buku['judul'], 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <a href="/buku/{{ $buku['id'] }}" class="font-bold text-stone-900 hover:text-emerald-700">{{ $buku['judul'] }}</a>
                        <p class="text-sm text-stone-500">{{ $buku['penulis'] }} · {{ $buku['kategori'] }}</p>
                        <p class="mt-1 text-xs text-stone-400">
                            Dipinjam {{ \mock_tanggal($loan['tanggal_pinjam']) }} —
                            Kembali {{ \mock_tanggal($loan['tanggal_kembali']) }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="rounded-full px-3 py-1 text-xs font-bold {{ \mock_status_class($loan['status']) }}">
                            {{ \mock_status_label($loan['status']) }}
                        </span>
                        @if ($loan['status'] === 'dipinjam')
                            <form method="POST" action="/pinjaman/{{ $loan['id'] }}/kembali">
                                @csrf
                                <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">
                                    Kembalikan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.app>
