<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;

    protected $fillable = [
        'ciudad',
        'fecha',
        'recibido_de',
        'direccion',
        'cc',
        'telefono',
        'suma_letras',
        'concepto',
        'marca',
        'linea',
        'color',
        'forma_pago',
    ];
}
