<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'id_user',
        'nip',
        'nidn',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'id_prodi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }

    public function proposal()
    {
        return $this->hasMany(Proposal::class, 'id_dosen', 'id');
    }
}
