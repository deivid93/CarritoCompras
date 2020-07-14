<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'imagen', 'nombre', 'descripcion', 'precio'
    ];


    /**
     * Get the post that owns the comment.
     */
    public function ordenes()
    {
        return $this->belongsToMany(Orden::class, 'orden_producto');
    }

}
