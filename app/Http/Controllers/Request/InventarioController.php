<?php

namespace App\Http\Controllers\Request;

use App\Service\Producto\SvcProducto;
use App\Service\SvcInventario;
use Illuminate\Support\Facades\Validator;


class InventarioController extends Controller
{
    public function getEquivalencias(SvcInventario $svcInventario)
    {
        $data = $this->request->all();
        $validator = Validator::make($data, [
            'start'  => 'required|numeric',
            'length' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $this->agregarError($validator->errors()->all());
        } else {
            $dataFilter = $this->getDataFromDataTables($data);
            $equivalencias = $svcInventario->listadoEquivalencias($dataFilter);
            $this->respuesta['data'] = $equivalencias['lista'];
            $this->respuesta['draw'] = $data['draw'];
            $this->respuesta['recordsTotal'] = $equivalencias['total'];
            $this->respuesta['recordsFiltered'] = $equivalencias['preLimitQty'];
            $this->respSinError();
            return $this->sendResponse();
        }
    }
}
