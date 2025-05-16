<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_documento',
        'numero_documento',
        'nombres',
        'apellidos',
        'departamento',
        'municipio',
        'direccion',
        'celular',
        'correo',
    ];

    /**
     * Relación: Un cliente puede tener muchas motos.
     */
    public function motos()
    {
        return $this->hasMany(\App\Models\Moto::class);
    }

    public function ventas()
{
    return $this->hasMany(Venta::class, 'cliente_id', 'id');
}


}
