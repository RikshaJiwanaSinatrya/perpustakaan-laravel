<x-layouts.admin :title="'Dashboard Admin'">
    <div class="mb-8">
        <h2 class="text-2xl font-black text-stone-900">Ringkasan Perpustakaan</h2>
        <p class="text-sm text-stone-500">Statistik peminjaman dan koleksi hari ini, {{ \mock_tanggal(date('Y-m-d')) }}.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['Judul Buku', $totalJudul, '📖', 'from-emerald-50 to-white', 'text-emerald-700'],
                ['Eksemplar', $totalKopi, '📚', 'from-sky-50 to-white', 'text-sky-700'],
                ['Anggota', $totalAnggota, '👥', 'from-violet-50 to-white', 'text-violet-700'],
                ['Sedang Dipinjam', $dipinjam, '🔄', 'from-amber-50 to-white', 'text-amber-700'],
            ];
        @endphp
        @foreach ($cards as [$label, $nilai, $ikon, $bg, $warna])
            <div class="rounded-2xl border border-stone-200 bg-gradient-to-br {{ $bg }} p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-stone-500">{{ $label }}</p>
                    <span class="text-xl">{{ $ikon }}</span>
                </div>
                <p class="mt-2 text-3xl font-black {{ $warna }}">{{ $nilai }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-3">
        <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">Kategori Koleksi</p>
            <p class="mt-2 text-2xl font-black text-stone-900">{{ $kategoriStats }}</p>
        </div>
        <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">Sudah Dikembalikan</p>
            <p class="mt-2 text-2xl font-black text-emerald-600">{{ $dikembalikan }}</p>
        </div>
        <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-stone-500">Terlambat</p>
            <p class="mt-2 text-2xl font-black text-rose-600">{{ $terlambat }}</p>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-stone-200 px-5 py-4">
            <h3 class="font-bold text-stone-900">Peminjaman Terbaru</h3>
            <a href="/admin/peminjaman" class="text-sm font-semibold text-emerald-700 hover:underline">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                    <tr>
                        <th class="px-5 py-3">Buku</th>
                        <th class="px-5 py-3">Anggota</th>
                        <th class="px-5 py-3">Pinjam</th>
                        <th class="px-5 py-3">Kembali</th>
                        <th class="px-5 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($terbaru as $loan)
                        @php
                            $buku = \mock_buku_by_id($loan['buku_id']);
                            $anggota = \mock_pengguna_by_id($loan['pengguna_id']);
                        @endphp
                        <tr class="hover:bg-stone-50">
                            <td class="px-5 py-3 font-medium text-stone-800">{{ $buku['judul'] ?? '(dihapus)' }}</td>
                            <td class="px-5 py-3">{{ $anggota['nama'] ?? '-' }}</td>
                            <td class="px-5 py-3 text-stone-500">{{ \mock_tanggal($loan['tanggal_pinjam']) }}</td>
                            <td class="px-5 py-3 text-stone-500">{{ \mock_tanggal($loan['tanggal_kembali']) }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ \mock_status_class($loan['status']) }}">
                                    {{ \mock_status_label($loan['status']) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-stone-400">Belum ada peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
