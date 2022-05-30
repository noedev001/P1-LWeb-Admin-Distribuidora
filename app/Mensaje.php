<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{


    protected $fillable = ['tipo','mensaje', 'status', 'fecha', 'cliente_id'];

    public function cliente()
    {
        return $this->belongsTo('Proyecto\Cliente');
    }
}
