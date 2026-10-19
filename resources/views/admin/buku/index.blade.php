<x-layouts.admin :title="'Kelola Buku'">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-stone-500">{{ count($buku) }} judul terdaftar di katalog.</p>
        <a href="/admin/buku/create" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">+ Tambah Buku</a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 text-xs uppercase tracking-wide text-stone-400">
                    <tr>
                        <th class="px-5 py-3">Judul</th>
                        <th class="px-5 py-3">Penulis</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Tahun</th>
                        <th class="px-5 py-3">Stok</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($buku as $item)
                        <tr class="hover:bg-stone-50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-7 shrink-0 items-center justify-center rounded bg-gradient-to-br {{ $item['warna'] }} text-xs font-black text-white/90">
                                        {{ strtoupper(substr($item['judul'], 0, 1)) }}
                                    </span>
                                    <a href="/buku/{{ $item['id'] }}" class="font-medium text-stone-800 hover:text-emerald-700">{{ $item['judul'] }}</a>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-stone-600">{{ $item['penulis'] }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-semibold text-stone-600">{{ $item['kategori'] }}</span>
                            </td>
                            <td class="px-5 py-3 text-stone-500">{{ $item['tahun'] }}</td>
                            <td class="px-5 py-3">
                                <span class="font-semibold {{ \mock_stok_tersedia($item) > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ \mock_stok_tersedia($item) }}/{{ $item['stok'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="/admin/buku/{{ $item['id'] }}/edit" class="rounded-lg border border-stone-300 px-3 py-1.5 text-xs font-semibold text-stone-600 hover:bg-stone-100">Edit</a>
                                    <form method="POST" action="/admin/buku/{{ $item['id'] }}" onsubmit="return confirm('Hapus buku \"{{ $item['judul'] }}\"?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-100">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-stone-400">Belum ada buku. Tambahkan buku pertama.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
