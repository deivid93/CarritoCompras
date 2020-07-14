<?php

namespace App\Http\Controllers;

use App\Orden;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrdenController extends Controller
{
    public function index(Request $request)
    {

        return Orden::all();

    }

    public function store(Request $request)
    {

        $orden = new Orden();
        $orden->save();
        $orden->productos()->attach($request->all());
        return $orden;
    }

}
