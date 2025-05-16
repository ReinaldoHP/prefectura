<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'marca',
        'modelo', 
        'fecha_venta',
        'precio',
        'observaciones',
        // ...
    ];




    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class);
    }

    public function moto()
    {
        return $this->belongsTo(\App\Models\Moto::class);
    }
}
