<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    // Menyesuaikan nama tabel
    protected $table = 'users'; // Sesuaikan dengan nama tabel pengguna yang digunakan
    protected $primaryKey = 'nip'; // kasih tahu Laravel primary key-nya NIP
    public $incrementing = false; // karena NIP bukan auto-increment
    protected $keyType = 'string'; // atau 'int' tergantung tipe NIP kamu
    protected $with = [
        'refPegawai'
    ];

    protected $fillable = [
        'nip',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userPivot()
    {
        return $this->hasMany(UserPivot::class, 'nip', 'nip');
    }

    public function latestUserPivot()
    {
        return $this->hasOne(UserPivot::class, 'nip', 'nip')->latestOfMany('id');
    }

    public function refPegawai()
    {
        return $this->hasOne(RefPegawai::class, 'nip', 'nip');
    }

    public function pelatihan2Usulan()
    {
        return $this->hasMany(Pelatihan2Usulan::class, 'nip', 'nip');
    }

    public function pelatihan3Pendaftaran()
    {
        return $this->hasMany(Pelatihan3Pendaftaran::class, 'user_nip', 'nip');
    }
}
