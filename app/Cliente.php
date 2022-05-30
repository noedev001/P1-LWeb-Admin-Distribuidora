<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;


use Tymon\JWTAuth\Contracts\JWTSubject;

class Cliente extends Model implements JWTSubject
{
  protected $fillable = ['cli_usuario', 'cli_password', 'cli_nombres', 'cli_apellidos'];

  public function datocliente() {
      return $this->hasOne('Proyecto\DatoCliente');
  }

  public function pedido()
  {
      return $this->hasMany('Proyecto\Pedido');
  }

  public function deposito()
  {
      return $this->hasMany('Proyecto\Deposito');
  }

  public function pagos()
  {
      return $this->hasMany('Proyecto\Pago');
  }

  public function factura()
    {
        return $this->hasMany('Proyecto\Factura');
    }

    public function cuota()
    {
        return $this->hasMany('Proyecto\Cuota');
    }

    public function sugerencia()
    {
        return $this->hasMany('Proyecto\Sugerencia');
    }
    public function mensaje()
  {
      return $this->hasMany('Proyecto\Mensaje');
  }
  public function toke()
  {
      return $this->hasMany('Proyecto\Toke');
  }




  public function getJWTIdentifier()
  {
      return $this->getKey();
  }

  public function getJWTCustomClaims()
  {
      return [];
  }
}
