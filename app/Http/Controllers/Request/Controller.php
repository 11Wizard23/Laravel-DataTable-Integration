<?php

namespace App\Http\Controllers\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public $respuesta = ['error' => 1, 'mensaje' => [], 'data' => []];

    /**
     * Hace que la respuesta no tenga errores.
     */
    public function respSinError()
    {
        $this->respuesta["error"] = 0;
    }

    /**
     * Agrega un mensaje de error a la respuesta.
     *
     * @param string $mensaje El mensaje de error que se agregará.
     */
    public function agregarError(string $mensaje)
    {
        $this->respuesta["mensaje"][] = $mensaje;
    }


    /**
     * Envía una respuesta JSON con el código de respuesta proporcionado.
     *
     * @param int $rcodigo El código de respuesta a enviar (por defecto es 200).
     * @return JsonResponse La respuesta JSON.
     */
    public function sendResponse(int $rcodigo = 200): JsonResponse
    {
        $jsonResponse = mb_convert_encoding($this->respuesta, 'UTF-8', 'UTF-8');
        return response()->json($jsonResponse, $rcodigo);
    }

    /**
     * Genera un array de datos basado en la entrada proporcionada desde DataTables.
     *
     * @param array $data Los datos de entrada desde DataTables.
     * @return array El array generado de datos.
     */
    public function getDataFromDataTables(array $data): array
    {
        $limit = [];
        if (isset($data['start']) && $data['length']) {
            $limit = [
                'skip' => $data['start'],
                'take' => $data['length']
            ];
        }
        $busqueda = [];
        if (isset($data['columns'])) {
            foreach ($data['columns'] as $columna) {
                $busqueda[] = [
                    'col' => $columna['data'],
                    'val' => $columna['search']['value']
                ];
            }
        }
        $orderBy = [];
        if (isset($data['order'])) {
            $orderBy = [
                'col' => $data['columns'][$data['order'][0]['column']]['data'],
                'val' => $data['order'][0]['dir']
            ];
        }
        return [
            'busqueda' => $busqueda,
            'orderBy'  => $orderBy,
            'limit'    => $limit
        ];
    }
}
