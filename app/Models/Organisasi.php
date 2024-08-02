<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    use HasFactory;

    protected $table = 'organisasi';

    protected $fillable = [
        'nama_organisasi',
        'jenis_organisasi',
        'tautan',
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'id_organisasi', 'id');
    }
}
