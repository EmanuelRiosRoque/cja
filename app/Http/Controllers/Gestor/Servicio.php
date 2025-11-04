<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class Servicio extends Controller
{
    public function gestor(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_global' => 'required',
                'url' => 'required|url',
                'tipo_archivo' => 'required|string|max:10',
                'fecha_documento' => 'required|date',
            ]);

            return response()->json([
                'status' => '100',
                'message' => 'Datos globales agregados.',
                'response' => $validated,
            ]);

        } catch (Throwable $e) {
            Log::error('Error en Servicio::gestor - ' . $e->getMessage());

            return response()->json([
                'status' => '200',
                'message' => 'No se pudo agregar los datos globales.',
                'response' => [],
            ]);
        }
    }
}
