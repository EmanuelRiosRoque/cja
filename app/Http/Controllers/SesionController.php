<?php

namespace App\Http\Controllers;

use App\Models\Oficialia\Solicitud;
use App\Models\Presentador;
use App\Models\Sesion;

class SesionController extends Controller
{
    public function index() 
    {
        return view('sesion.index');
    }

    public function list() 
    {
        return view('sesion.list');
    }

    public function ordenDia(Sesion $sesion)
    {
        $presentadores = Presentador::all();

        return view('sesion.ordenDia.index', [
            'sesion' => $sesion,
            'presentadores' => $presentadores,
        ]);
    }

    public function temas(Sesion $sesion)
    {
        return view('sesion.ordenDia.temas', [
            'sesion' => $sesion,
        ]);
    }

    public function adjuntar(Sesion $sesion)
    {
        return view('sesion.ordenDia.adjuntar', [
            'sesion' => $sesion,
        ]);
    }

    public function ponencia(Sesion $sesion)
    {
        return view('sesion.ordenDia.ponencia', [
            'sesion' => $sesion,
        ]);
    }

    // VIEWS PARA ADMINISTRADOR
    public function monitor(Sesion $sesion)
    {
        return view('sesion.ordenDia.administrador.monitor', [
            'sesion' => $sesion,
        ]);
    }

    // VIEWS PARA CORDINADOR
    public function asignar(Sesion $sesion)
    {
        return view('sesion.ordenDia.coordinador.asignar', [
            'sesion' => $sesion,
        ]);
    }

    // VIEWS PARA PLENO
    public function asignados()
    {
        //Solicitudes = asignadas por oficilia

        $user = auth()->user();

        if ($user->hasRole('Pleno')) {
            $solicitudes = Solicitud::where('fk_areaTurno', 1)
            ->whereNot('fk_estatus', 4)
            ->get();
        }
        
        return view('sesion.ordenDia.pleno.asignados', [
            'solicitudes' => $solicitudes 
        ]);
    }

}
