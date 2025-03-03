<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;
    protected $table = 'kelompok';
    protected $fillable = ['nama_kelompok','kelas_id', 'jurusan_id', 'guru_id', 'user_id_1', 'user_id_2', 'user_id_3'];


    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id'); // pastikan kolom foreign key sesuai dengan nama kolom pada tabel materi
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id_1', 'user_id_2', 'user_id_3');
    }

}
