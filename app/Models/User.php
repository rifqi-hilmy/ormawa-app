<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  ["admin", "mahasiswa", "dosen"][$value],
        );
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id_user', 'id');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id_user', 'id');
    }

    public function dirmawa()
    {
        return $this->hasOne(Dirmawa::class, 'id_user', 'id');
    }

    public function proposal()
    {
        return $this->hasMany(Proposal::class, 'id_user', 'id');
    }
}
