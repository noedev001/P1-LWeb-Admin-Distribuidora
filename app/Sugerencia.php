<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Sugerencia extends Model
{
    
    protected $fillable = ['sugerencias', 'cliente_id'];

    public function cliente()
    {
        return $this->belongsTo('Proyecto\Cliente');
    }
}
