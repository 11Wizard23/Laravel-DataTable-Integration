<?php

namespace App\Service;

use App\Models\Maestro\EquivalenciaInventario as CodigosInventario;


class SvcInventario extends SvcMaestro
{
    public function listadoEquivalencias($dataFilter = [])
    {
        try {
            $datos = CodigosInventario::select(
                'codigo_interno',
                'codigo_proveedor',
                'proveedor',
                'registro',
                'usuario_registro'
            );
            $model = new CodigosInventario();
            $dataReturn = $this->aplicarFiltros($datos, $model, $dataFilter);
            return $dataReturn;
        } catch (\Exception $exc) {
            Log::channel('database')->info($exc);
            return [];
        }
    }
}
