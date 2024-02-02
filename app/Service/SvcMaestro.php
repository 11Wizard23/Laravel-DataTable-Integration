<?php

namespace App\Service;

class SvcMaestro
{

    /**
     * Apliy filters in sql request middle 
     * @param  Object $lista The midle mysql request
     * @param  Model  $model The model of the initial request
     * @return array  $dataFilter The filter, usually used by datatables
     */
    public function aplicarFiltros($lista, $model, $dataFilter)
    {
        $total = $lista->get()->count();
        if (!empty($dataFilter['busqueda'])) {
            foreach ($dataFilter['busqueda'] as $columna) {
                if ($columna['val'] != null) {
                    if (in_array($columna['col'], $model->getFillable())) {
                        $lista = $lista->where($model->getTable() . '.' . $columna['col'], 'like', '%' . $columna['val'] . '%');
                    } else {
                        $lista = $lista->having($columna['col'], 'like', '%' . $columna['val'] . '%');
                    }
                }
            }
        }
        if (!empty($dataFilter['orderBy'])) {
            $lista = $lista->orderByRaw($dataFilter['orderBy']['col'] . ' ' . $dataFilter['orderBy']['val']);
        }
        $preLimit = $lista->get();
        if (!empty($dataFilter['limit'])) {
            if($dataFilter['limit']['take'] != -1){
                $lista = $lista->take($dataFilter['limit']['take'] ?? $model::count())
                ->skip($dataFilter['limit']['skip'] ?? 0);
            }
        }
        $lista = $lista->get();
        if (isset($lista)) {
            $lista = $lista->toArray();
            $preLimitQty = count($preLimit);
        }
        return [
            'lista'       => $lista,
            'preLimitQty' => $preLimitQty,
            'total'       => $total
        ];
    }

}
