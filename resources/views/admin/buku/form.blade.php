<x-layouts.admin :title="$buku ? 'Edit Buku' : 'Tambah Buku'">
    @php
        $aksi = $buku ? '/admin/buku/' . $buku['id'] : '/admin/buku';
        $method = $buku ? 'PUT' : 'POST';
    @endphp

    <div class="mx-auto max-w-2xl">
        <a href="/admin/buku" class="mb-6 inline-block text-sm font-medium text-stone-500 hover:text-emerald-700">← Kembali ke daftar buku</a>

        <form method="POST" action="{{ $aksi }}" class="space-y-5 rounded-2xl border border-stone-200 bg-white p-8 shadow-sm">
            @csrf
            @method($method)

            <div>
                <label for="judul" class="mb-1.5 block text-sm font-medium text-stone-700">Judul Buku *</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $buku['judul'] ?? '') }}" required
                       class="w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                       placeholder="Contoh: Laskar Pelangi">
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="penulis" class="mb-1.5 block text-sm font-medium text-stone-700">Penulis *</label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $buku['penulis'] ?? '') }}" required
                           class="w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                           placeholder="Nama penulis">
                </div>
                <div>
                    <label for="penerbit" class="mb-1.5 block text-sm font-medium text-stone-700">Penerbit *</label>
                    <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku['penerbit'] ?? '') }}" required
                           class="w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                           placeholder="Nama penerbit">
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <label for="tahun" class="mb-1.5 block text-sm font-medium text-stone-700">Tahun Terbit *</label>
                    <input type="number" id="tahun" name="tahun" value="{{ old('tahun', $buku['tahun'] ?? date('Y')) }}" min="1900" max="2030" required
                           class="w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                </div>
                <div>
                    <label for="stok" class="mb-1.5 block text-sm font-medium text-stone-700">Stok *</label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', $buku['stok'] ?? 1) }}" min="0" required
                           class="w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                </div>
                <div>
                    <label for="kategori" class="mb-1.5 block text-sm font-medium text-stone-700">Kategori *</label>
                    <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $buku['kategori'] ?? '') }}" required list="kategori-list"
                           class="w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                           placeholder="Fiksi, Sejarah…">
                    <datalist id="kategori-list">
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat }}"></option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div>
                <label for="isbn" class="mb-1.5 block text-sm font-medium text-stone-700">ISBN</label>
                <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $buku['isbn'] ?? '') }}"
                       class="w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                       placeholder="978-…">
            </div>

            <div>
                <label for="deskripsi" class="mb-1.5 block text-sm font-medium text-stone-700">Sinopsis</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                          placeholder="Deskripsi singkat buku…">{{ old('deskripsi', $buku['deskripsi'] ?? '') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">
                    {{ $buku ? 'Simpan Perubahan' : 'Tambah Buku' }}
                </button>
                <a href="/admin/buku" class="rounded-xl border border-stone-300 px-6 py-2.5 text-sm font-semibold text-stone-600 hover:bg-stone-100">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
