<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OficialiaController extends Controller
{
    
    public function registroDocumento() {
        return view('oficialia.registroDocumento');
    }

    public function turnos() {
        return view('oficialia.turnos');
    }
}
