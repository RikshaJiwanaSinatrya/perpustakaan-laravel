<x-layouts.admin :title="'Data Anggota'">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-stone-500">{{ count($anggota) }} anggota terdaftar.</p>
        <a href="/register" class="rounded-xl border border-stone-300 bg-white px-5 py-2.5 text-sm font-semibold text-stone-600 hover:bg-stone-100">
            + Buat Anggota via Form Publik
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                    <tr>
                        <th class="px-5 py-3">No. Anggota</th>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Bergabung</th>
                        <th class="px-5 py-3">Sedang Dipinjam</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($anggota as $a)
                        <tr class="hover:bg-stone-50">
                            <td class="px-5 py-3">
                                <span class="rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-bold text-stone-600">{{ $a['no_anggota'] }}</span>
                            </td>
                            <td class="px-5 py-3 font-medium text-stone-800">{{ $a['nama'] }}</td>
                            <td class="px-5 py-3 text-stone-500">{{ $a['email'] }}</td>
                            <td class="px-5 py-3 text-stone-500">{{ \mock_tanggal($a['bergabung']) }}</td>
                            <td class="px-5 py-3">
                                @if ($a['dipinjam'] > 0)
                                    <span class="rounded-full bg-sky-100 px-2.5 py-0.5 text-xs font-bold text-sky-700">{{ $a['dipinjam'] }} buku</span>
                                @else
                                    <span class="text-xs text-stone-400">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-stone-400">Belum ada anggota.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
