<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'unit_id',
        'kategori_id',
        'judul',
        'isi_laporan',
        'lokasi',
        'lampiran',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function unit()
    {
        return $this->belongsTo(UnitLayanan::class);
    }
    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class);
    }

    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class);
    }
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

}
