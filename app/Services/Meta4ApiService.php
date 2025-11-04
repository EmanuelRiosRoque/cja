<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Meta4ApiService
{
    /**
     * Consulta un empleado en el servicio META4.
     *
     * @param string $numEmpleado
     * @return array|null
     */
    public function obtenerEmpleado(string $numEmpleado): ?array
    {
        try {
            $url = "http://172.19.202.44/WebServices/META/api/Empleado?NumEmpleado={$numEmpleado}";

            $response = Http::timeout(10)->get($url);

            if ($response->failed()) {
                Log::warning("META4 no respondió para {$numEmpleado}");
                return null;
            }

            $data = $response->json();

            // Validar estructura esperada
            if (!isset($data['empleado'])) {
                Log::warning("Respuesta inválida de META4", $data);
                return null;
            }

            return $data['empleado'];
        } catch (\Exception $e) {
            Log::error('Error consultando Meta4: '.$e->getMessage());
            return null;
        }
    }

    /**
     * Verifica si un empleado está activo en Meta4.
     *
     * @param string $numEmpleado
     * @return array|null  Retorna los datos si está activo, null si no.
     */
    public function validarActivo(string $numEmpleado): ?array
    {
        $empleado = $this->obtenerEmpleado($numEmpleado);

        if (!$empleado) {
            return null;
        }

        // Validar estatus
        if (strtoupper($empleado['estatus'] ?? '') !== 'ACTIVO') {
            return null;
        }

        return $empleado;
    }
}
