<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = false; // tu tabla no tiene created_at/updated_at

    protected $fillable = ['usuario', 'contra', 'rol', 'id_tienda', 'correo'];
    protected $hidden   = ['contra'];

    // Laravel espera 'password'; tu columna se llama 'contra'
    public function getAuthPassword()
    {
        return $this->contra;
    }
}