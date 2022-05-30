<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $fillable = ['aviso', 'fecha', 'cliente_id', 'user_id'];

    
}
