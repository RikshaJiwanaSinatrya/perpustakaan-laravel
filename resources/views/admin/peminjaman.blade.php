<x-layouts.admin :title="'Kelola Peminjaman'">
    <div class="mb-6 flex flex-wrap items-center gap-3">
        @php
            $dipinjam = count(array_filter($pinjaman, fn ($l) => $l['status'] === 'dipinjam'));
            $terlambat = count(array_filter($pinjaman, fn ($l) => $l['status'] === 'terlambat'));
            $selesai = count(array_filter($pinjaman, fn ($l) => $l['status'] === 'dikembalikan'));
        @endphp
        <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-bold text-sky-700">{{ $dipinjam }} dipinjam</span>
        <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-700">{{ $terlambat }} terlambat</span>
        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">{{ $selesai }} selesai</span>
        <span class="text-sm text-stone-400">Total {{ count($pinjaman) }} transaksi</span>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                    <tr>
                        <th class="px-5 py-3">#</th>
                        <th class="px-5 py-3">Buku</th>
                        <th class="px-5 py-3">Anggota</th>
                        <th class="px-5 py-3">Tgl Pinjam</th>
                        <th class="px-5 py-3">Tgl Kembali</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($pinjaman as $loan)
                        @php
                            $buku = \mock_buku_by_id($loan['buku_id']);
                            $anggota = \mock_pengguna_by_id($loan['pengguna_id']);
                        @endphp
                        <tr class="hover:bg-stone-50">
                            <td class="px-5 py-3 text-stone-400">{{ $loan['id'] }}</td>
                            <td class="px-5 py-3 font-medium text-stone-800">{{ $buku['judul'] ?? '(buku dihapus)' }}</td>
                            <td class="px-5 py-3">
                                <p class="font-medium text-stone-700">{{ $anggota['nama'] ?? '-' }}</p>
                                <p class="text-xs text-stone-400">{{ $anggota['no_anggota'] ?? '' }}</p>
                            </td>
                            <td class="px-5 py-3 text-stone-500">{{ \mock_tanggal($loan['tanggal_pinjam']) }}</td>
                            <td class="px-5 py-3 text-stone-500">{{ \mock_tanggal($loan['tanggal_kembali']) }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ \mock_status_class($loan['status']) }}">
                                    {{ \mock_status_label($loan['status']) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex justify-end gap-2">
                                    @if ($loan['status'] === 'dipinjam')
                                        <form method="POST" action="/admin/peminjaman/{{ $loan['id'] }}/kembali">
                                            @csrf
                                            <button type="submit" class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100">
                                                Tandai Kembali
                                            </button>
                                        </form>
                                        <form method="POST" action="/admin/peminjaman/{{ $loan['id'] }}/terlambat">
                                            @csrf
                                            <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-100">
                                                Terlambat
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-stone-300">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-stone-400">Belum ada transaksi peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
