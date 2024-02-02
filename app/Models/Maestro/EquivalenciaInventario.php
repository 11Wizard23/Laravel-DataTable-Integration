<?php

namespace App\Models\Maestro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EquivalenciaInventario extends Model
{
    use HasFactory,
        Notifiable;

    protected $table = "maestro_equivalencia_inventario";
    protected $primaryKey = "id";

    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id", "codigo_interno", "codigo_proveedor", "proveedor", "registro", "usuario_registro"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
