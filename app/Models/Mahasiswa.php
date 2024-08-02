<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'id_user',
        'nim',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'id_organisasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'id_organisasi', 'id');
    }

    // public function getJenisKelaminAttribute($value)
    // {
    //     return ["L" => "Laki-laki", "P" => "Perempuan"][$value];
    // }
}
