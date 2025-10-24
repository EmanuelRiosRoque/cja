<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NuevaSesionController extends Controller
{
    public function index() {
        return view('sesion.index');
    }
}
