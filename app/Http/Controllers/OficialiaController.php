<?php

namespace App\Http\Controllers;

use App\Models\Catalogos\CatAnexo;
use App\Models\Catalogos\CatAreaProcedencia;
use App\Models\Catalogos\CatAreaTurno;
use App\Models\Catalogos\CatEntrega;
use App\Models\Catalogos\CatTipoDoc;
use App\Models\Catalogos\CatTipoProcedencia;

class OficialiaController extends Controller
{
    public function registroDocumento($id = null)
    {
        return view('oficialia.registroDocumento', compact('id'));
    }


    public function turnos() {
        return view('oficialia.turnos');
    }

    public function reportes() {
        return view('oficialia.reportes');
    }
}
