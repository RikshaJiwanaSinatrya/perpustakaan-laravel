<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku (Mendukung fitur search & filter kategori untuk FE)
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Filter pencarian berdasarkan judul, penulis, atau ISBN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori_id
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $bukus = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar buku berhasil diambil',
            'data'    => $bukus
        ], 200);
    }

    /**
     * Menambahkan koleksi buku baru + Upload Cover
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:50|unique:bukus,isbn',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Maks 2MB
        ]);

        // Simpan gambar cover jika diunggah
        if ($request->hasFile('cover')) {
            // Tersimpan di storage/app/public/covers
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku = Buku::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan',
            'data'    => $buku->load('kategori')
        ], 201);
    }

    /**
     * Menampilkan detail 1 buku
     */
    public function show(Buku $buku)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail buku',
            'data'    => $buku->load('kategori')
        ], 200);
    }

    /**
     * Memperbarui data buku & mengganti file cover lama jika ada upload baru
     */
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:50|unique:bukus,isbn,' . $buku->id,
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Jika ada upload cover baru, hapus cover lama lalu simpan yang baru
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data buku berhasil diperbarui',
            'data'    => $buku->load('kategori')
        ], 200);
    }

    /**
     * Menghapus buku beserta file gambar covernya
     */
    public function destroy(Buku $buku)
    {
        // Hapus file cover dari storage jika ada
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }
}