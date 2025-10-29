<?php

namespace App\Services;

use App\Models\Documento;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DocumentoService
{
    protected string $endpoint = 'https://gestordocumental.poderjudicialcdmx.gob.mx/api/sintra';

    /**
     * Envía uno o varios documentos y los registra en BD.
     *
     * @param  \App\Models\Tema  $tema
     * @param  array  $documentos  Estructura: [['path' => 'storage/...', 'name' => 'archivo.pdf'], ...]
     * @return array  Resultados de los envíos
     */
    public function enviarYRegistrar($tema, array $documentos): array
    {
        // Si es un solo documento, lo envolvemos en un array
        if (isset($documentos['path']) || isset($documentos['url'])) {
            $documentos = [$documentos];
        }

        $resultados = [];

        foreach ($documentos as $doc) {
            $url = $doc['url'] ?? $doc['path'] ?? null;
            $nombre = $doc['nombre'] ?? $doc['name'] ?? null;

            if (empty($url) || empty($nombre)) {
                Log::warning('Documento inválido sin nombre o ruta.', $doc);
                continue;
            }

            // Ruta física real en storage/app/public
            $ruta = storage_path('app/public/' . str_replace('storage/', '', $url));

            $respuesta = $this->enviar($ruta, $nombre);

            if ($respuesta && ($respuesta['status'] ?? false) === true) {
                // Guardar registro en BD
                Documento::create([
                    'tema_id'  => $tema->id,
                    'nombre'   => $nombre,
                    'url'      => $respuesta['url'] ?? null,
                    'idGlobal' => $respuesta['idGlobal'] ?? null,
                    'tipo'     => pathinfo($nombre, PATHINFO_EXTENSION),
                ]);

                Log::info("Documento {$nombre} guardado correctamente en BD.");

                // Eliminar el archivo local solo si fue enviado exitosamente
                if (file_exists($ruta)) {
                    unlink($ruta);
                    Log::info("Archivo local eliminado: {$ruta}");
                }
            } else {
                Log::error("Error al enviar documento {$nombre}", [
                    'respuesta' => $respuesta,
                ]);
            }

            $resultados[] = [
                'nombre' => $nombre,
                'respuesta' => $respuesta,
            ];
        }

        return $resultados;
    }


    /**
     * Envía un solo documento al Gestor Documental.
     *
     * @param  string  $rutaFisica
     * @param  string  $nombreArchivo
     * @param  array   $metadata
     * @return array|null
     */
    public function enviar(string $rutaFisica, string $nombreArchivo, array $metadata = []): ?array
    {
        if (!file_exists($rutaFisica)) {
            Log::warning("Archivo no encontrado: {$rutaFisica}");
            return null;
        }

        try {
            $base64 = base64_encode(file_get_contents($rutaFisica));

            $payload = [
                'metadata' => array_merge([
                    'id_datoadicional' => 9,
                    'area_tsjcdmx' => 'DDMS',
                ], $metadata),
                'filename' => $nombreArchivo,
                'doc_base64' => $base64,
            ];

            $client = new Client();
            $response = $client->post($this->endpoint, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($payload),
                'timeout' => 20,
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            Log::info("Documento enviado correctamente: {$nombreArchivo}");

            return $body;
        } catch (\Throwable $e) {
            Log::error("Error al enviar documento {$nombreArchivo}: " . $e->getMessage());
            return null;
        }
    }
}
