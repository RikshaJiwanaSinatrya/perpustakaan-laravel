<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Tarif denda keterlambatan per hari (Rp 1.000)
     */
    private const DENDA_PER_HARI = 1000;

    /**
     * Menampilkan daftar transaksi peminjaman
     * (Bisa difilter berdasarkan user_id atau status)
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user:id,name,nis,kelas', 'buku.kategori']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman berhasil diambil',
            'data'    => $peminjamans
        ], 200);
    }

    /**
     * Transaksi Peminjaman Baru (Cek Stok & Kurangi Stok Otomatis)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
        ]);

        // Cek apakah siswa masih meminjam buku yang sama dan belum dikembalikan
        $masihPinjam = Peminjaman::where('user_id', $validated['user_id'])
            ->where('buku_id', $validated['buku_id'])
            ->where('status', 'dipinjam')
            ->exists();

        if ($masihPinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ini masih meminjam buku yang sama dan belum dikembalikan.'
            ], 422);
        }

        try {
            $peminjaman = DB::transaction(function () use ($validated) {
                // Kunci baris buku sementara agar tidak bentrok jika dipinjam bersamaan
                $buku = Buku::lockForUpdate()->findOrFail($validated['buku_id']);

                // Cek ketersediaan stok buku
                if ($buku->stok <= 0) {
                    throw new \Exception('Stok buku sedang habis dan tidak dapat dipinjam.');
                }

                // Kurangi stok buku otomatis (-1)
                $buku->decrement('stok');

                // Buat record peminjaman (Jatuh tempo otomatis 7 hari ke depan)
                return Peminjaman::create([
                    'user_id'             => $validated['user_id'],
                    'buku_id'             => $validated['buku_id'],
                    'tanggal_pinjam'      => now()->toDateString(),
                    'tanggal_jatuh_tempo' => now()->addDays(7)->toDateString(),
                    'tanggal_kembali'     => null,
                    'status'              => 'dipinjam',
                    'denda'               => 0,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman buku berhasil dicatat',
                'data'    => $peminjaman->load(['user:id,name,nis,kelas', 'buku'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Menampilkan detail 1 transaksi peminjaman
     */
    public function show(Peminjaman $peminjaman)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi peminjaman',
            'data'    => $peminjaman->load(['user:id,name,nis,kelas', 'buku.kategori'])
        ], 200);
    }

    /**
     * Transaksi Pengembalian Buku (Tambah Stok & Kalkulasi Denda Otomatis)
     */
    public function kembalikan(Peminjaman $peminjaman)
    {
        // Pastikan buku belum pernah dikembalikan sebelumnya
        if ($peminjaman->status !== 'dipinjam') {
            return response()->json([
                'success' => false,
                'message' => 'Buku pada transaksi ini sudah pernah dikembalikan.'
            ], 422);
        }

        $peminjaman = DB::transaction(function () use ($peminjaman) {
            $tanggalKembali = Carbon::now()->startOfDay();
            $jatuhTempo     = Carbon::parse($peminjaman->tanggal_jatuh_tempo)->startOfDay();

            $denda  = 0;
            $status = 'dikembalikan';

            // Cek apakah tanggal kembali melewati tanggal jatuh tempo
            if ($tanggalKembali->gt($jatuhTempo)) {
                $hariTerlambat = (int) $jatuhTempo->diffInDays($tanggalKembali);
                $denda         = $hariTerlambat * self::DENDA_PER_HARI;
                $status        = 'terlambat';
            }

            // Update data transaksi peminjaman
            $peminjaman->update([
                'tanggal_kembali' => $tanggalKembali->toDateString(),
                'status'          => $status,
                'denda'           => $denda,
            ]);

            // Kembalikan stok buku (+1)
            $peminjaman->buku()->increment('stok');

            return $peminjaman;
        });

        return response()->json([
            'success' => true,
            'message' => $peminjaman->denda > 0
                ? "Buku dikembalikan terlambat. Denda sebesar Rp " . number_format($peminjaman->denda, 0, ',', '.')
                : "Buku berhasil dikembalikan tepat waktu tanpa denda.",
            'data'    => $peminjaman->load(['user:id,name,nis,kelas', 'buku'])
        ], 200);
    }

    /**
     * Menghapus data riwayat transaksi
     * (Jika status masih 'dipinjam', kembalikan stok bukunya dulu)
     */
    public function destroy(Peminjaman $peminjaman)
    {
        DB::transaction(function () use ($peminjaman) {
            if ($peminjaman->status === 'dipinjam') {
                $peminjaman->buku()->increment('stok');
            }
            $peminjaman->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Data transaksi peminjaman berhasil dihapus'
        ], 200);
    }
}