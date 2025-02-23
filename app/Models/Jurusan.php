<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusan';
    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
    ];

    // Definisikan relasi jika perlu
    public function GuruMapel()
    {
        return $this->hasOne(guru::class);
    }
    public function videos()
    {
        return $this->hasMany(Video::class, 'mapel_id');
    }
    // Relasi ke Materi
    public function materi()
    {
        return $this->hasMany(Materi::class);
    }
    // Relasi ke Ujian
    public function ujians()
    {
        return $this->hasMany(Ujian::class, 'mapel_id');
    }

}
