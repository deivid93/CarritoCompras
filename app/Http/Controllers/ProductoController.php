<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index(Request $request)
    {

        return Producto::all();

    }

    public function store(Request $request)
    {

        $exploded = explode (',', $request->imagen);
        $decoded = base64_decode($exploded[1]);
        if(str_contains($exploded[0], 'jpeg')){
            $extension = 'jpg';
        }else{
            $extension = 'png';
        }

        $filename = Str::random(5) . '.'. $extension;
        $path = public_path() . '/image/' .$filename;
        file_put_contents($path, $decoded);

        $producto = new Producto();
        $producto->imagen = $filename;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->save();

        return $producto;
    }

}
