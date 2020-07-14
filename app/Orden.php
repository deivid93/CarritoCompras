<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';
    protected $fillable = [
        'descripcion'
    ];

    /**
     * The roles that belong to the user.
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'orden_producto');
    }


}
