<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proposal';

    protected $fillable = [
        'judul',
        'tgl_kegiatan',
        'surat_pengantar',
        'file_proposal',
        'lampiran_proposal',
        'status_dosen',
        'status_dirmawa',
        'id_user',
        'id_dosen',
        'id_dirmawa',
    ];

    protected $appends = [
        'surat_pengantar_url',
        'file_proposal_url',
        'lampiran_proposal_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen', 'id');
    }

    public function dirmawa()
    {
        return $this->belongsTo(User::class, 'id_dirmawa', 'id');
    }

    public function getSuratPengantarUrlAttribute()
    {
        return $this->surat_pengantar ? asset('storage/' . $this->surat_pengantar) : null;
    }

    public function getFileProposalUrlAttribute()
    {
        return $this->file_proposal ? asset('storage/' . $this->file_proposal) : null;
    }

    public function getLampiranProposalUrlAttribute()
    {
        return $this->lampiran_proposal ? asset('storage/' . $this->lampiran_proposal) : null;
    }
}
