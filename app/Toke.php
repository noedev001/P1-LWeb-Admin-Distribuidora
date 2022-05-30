<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Toke extends Model
{
    protected $fillable = ['token', 'cliente_id'];

    public function cliente()
    {
        return $this->belongsTo('Proyecto\Cliente');
    }
}
