<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seeder Akun Multi-Role (Admin, Petugas, Siswa)
        User::create([
            'name' => 'Administrator',
            'nis' => null,
            'kelas' => null,
            'email' => 'admin@perpus.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Petugas Perpustakaan',
            'nis' => null,
            'kelas' => null,
            'email' => 'petugas@perpus.com',
            'role' => 'petugas',
            'password' => Hash::make('password123'),
        ]);

        $siswa1 = User::create([
            'name' => 'Budi Santoso',
            'nis' => '10203040',
            'kelas' => 'XII PPLG 1',
            'email' => 'budi@siswa.com',
            'role' => 'siswa',
            'password' => Hash::make('password123'),
        ]);

        // 2. Seeder Kategori Buku
        $katPemrograman = Kategori::create(['nama_kategori' => 'Pemrograman']);
        $katNovel = Kategori::create(['nama_kategori' => 'Novel & Fiksi']);
        $katSains = Kategori::create(['nama_kategori' => 'Sains & Teknologi']);

        // 3. Seeder Koleksi Buku
        $buku1 = Buku::create([
            'kategori_id' => $katPemrograman->id,
            'judul' => 'Mastering Laravel 12 & React',
            'isbn' => '978-602-1234-01-1',
            'penulis' => 'Ahmad & Tim',
            'penerbit' => 'Informatika Bandung',
            'tahun_terbit' => 2026,
            'stok' => 10,
            'cover' => null,
        ]);

        $buku2 = Buku::create([
            'kategori_id' => $katNovel->id,
            'judul' => 'Laskar Pelangi',
            'isbn' => '978-979-3062-79-2',
            'penulis' => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'tahun_terbit' => 2005,
            'stok' => 5,
            'cover' => null,
        ]);

        Buku::create([
            'kategori_id' => $katSains->id,
            'judul' => 'Pengantar Kecerdasan Buatan',
            'isbn' => '978-602-1234-02-8',
            'penulis' => 'Dr. Hendra Wijaya',
            'penerbit' => 'Elex Media',
            'tahun_terbit' => 2024,
            'stok' => 7,
            'cover' => null,
        ]);

        // 4. Seeder Contoh Transaksi Peminjaman
        Peminjaman::create([
            'user_id' => $siswa1->id,
            'buku_id' => $buku1->id,
            'tanggal_pinjam' => now()->subDays(3)->toDateString(),
            'tanggal_jatuh_tempo' => now()->addDays(4)->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'dipinjam',
            'denda' => 0,
        ]);
    }
}