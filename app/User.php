<?php

namespace Proyecto;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function asignar() {
        return $this->hasOne('Proyecto\Asignar');
    }


    public function perfil() {
        return $this->hasOne('Proyecto\Perfil');
    }


    public function pedido()
    {
        return $this->hasMany('Proyecto\Pedido');
    }

    public function cuota()
    {
        return $this->hasMany('Proyecto\Cuota');
    }
}
