<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan seluruh daftar kategori beserta jumlah bukunya
     */
    public function index()
    {
        $kategoris = Kategori::withCount('bukus')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kategori berhasil diambil',
            'data'    => $kategoris
        ], 200);
    }

    /**
     * Menyimpan kategori baru (Validasi unik)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah ada.',
        ]);

        $kategori = Kategori::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data'    => $kategori
        ], 201);
    }

    /**
     * Menampilkan detail 1 kategori beserta daftar bukunya
     */
    public function show(Kategori $kategori)
    {
        $kategori->load('bukus');

        return response()->json([
            'success' => true,
            'message' => 'Detail kategori',
            'data'    => $kategori
        ], 200);
    }

    /**
     * Mengubah nama kategori
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            // Abaikan ID kategori saat ini agar tidak error unique saat disimpan
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori,' . $kategori->id,
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah digunakan.',
        ]);

        $kategori->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'data'    => $kategori
        ], 200);
    }

    /**
     * Menghapus kategori dengan Safety Check relasi buku
     */
    public function destroy(Kategori $kategori)
    {
        // Safety Check: Cek apakah masih ada buku di dalam kategori ini
        if ($kategori->bukus()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih memiliki koleksi buku terkait.'
            ], 422);
        }

        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ], 200);
    }
}