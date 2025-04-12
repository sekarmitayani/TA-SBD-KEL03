<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Barang extends Model
{
    use SoftDeletes; 
    protected $table = 'barangs'; 

    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama_barang', 
        'kategori_id', 
        'spesifikasi', 
        'tanggal_pembelian', 
        'harga', 
        'status', 
        'lokasi', 
        'kode_aset', 
        'gambar',
        'is_deleted',
        'stok'
    ];

    protected $dates = ['deleted_at']; // Tambahkan ini juga

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_barang', 'id_barang');
    }

    public function pemeliharaans()
    {
        return $this->hasMany(Pemeliharaan::class, 'id_barang', 'id_barang');
    }
}
