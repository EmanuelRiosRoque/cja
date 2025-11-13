<?php

namespace App\Http\Controllers\Gestor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class Servicio extends Controller
{
    public function gestor(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_global' => 'required',
                'url_privada' => 'required',
                'folio' => 'nullable',
                'tipo_archivo' => 'required|string|max:10',
                'fecha_documento' => 'required|date',
            ]);

            $id = DB::table('documentos')->insertGetId([
                'nombre' => null,             
                'idGlobal' => $validated['id_global'],
                'rutaGlobal' => $validated['url_privada'],
                'tipoArchivo' => $validated['tipo_archivo'],
                'fechaAlta' => $validated['fecha_documento'],
                'fechaModificacion' => now(),
                'fk_solicitud' => $validated['folio'],          
                'fk_tema' => null,               
            ]);

            return response()->json([
                'status' => '100',
                'message' => 'Datos globales agregados.',
                'response' => [
                    'insert_id' => $id,
                    'datos' => $validated,
                ],
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
