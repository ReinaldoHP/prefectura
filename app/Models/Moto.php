<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'modelo', 'marca',   'año'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);  // Relación inversa
    }

    public function venta()
    {
        return $this->hasOne(\App\Models\Venta::class);
    }

    public function marcaModelo()
    {
        return $this->belongsTo(MarcaModelo::class, 'marca_modelo_id');
    }


}