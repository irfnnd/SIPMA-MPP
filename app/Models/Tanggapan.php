<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    protected $fillable = ['pengaduan_id', 'isi_tanggapan', 'petugas_id'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
