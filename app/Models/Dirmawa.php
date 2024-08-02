<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dirmawa extends Model
{
    use HasFactory;

    protected $table = 'dirmawa';

    protected $fillable = [
        'id_user',
        'nip',
        'nidn',
        'jenis_kelamin',
        'alamat',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function proposal()
    {
        return $this->hasMany(Proposal::class, 'id_dirmawa', 'id');
    }
}
