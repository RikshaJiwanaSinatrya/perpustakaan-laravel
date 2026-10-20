<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'kategori_id', 'judul', 'isbn', 'penulis', 
        'penerbit', 'tahun_terbit', 'stok', 'cover'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}