<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    protected $fillable = [
        'nama_agenda',
        'tgl_mulai',
        'tgl_selesai',
        'tempat',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
        'id_user',
        'id_proposal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'id_proposal', 'id');
    }
}
