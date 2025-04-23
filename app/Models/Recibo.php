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
        'estado',
        'valor_soat',
        'valor_tecnomecanica',
        'otros_documentos',
        'abonos',
    ];

    // Método para aprobar el recibo
    public function aprobar()
    {
        if (auth()->user()->isCaja()) {
            $this->estado = 'aprobado';
            $this->save();
        }
    }

    // Método para realizar un abono
    public function realizarAbono($monto)
    {
        if (auth()->user()->isCaja()) {
            // Lógica para realizar un abono, por ejemplo, sumando a un campo `abonos`
            $this->abonos += $monto;
            $this->save();
        }
    }

     // 👉 Método que solo Caja puede usar para actualizar campos especiales
     public function actualizarValoresCaja(array $datos): void
     {
         if (auth()->user()?->isCaja()) {
             $this->fill([
                 'valor_soat' => $datos['valor_soat'] ?? $this->valor_soat,
                 'valor_tecnomecanica' => $datos['valor_tecnomecanica'] ?? $this->valor_tecnomecanica,
                 'otros_documentos' => $datos['otros_documentos'] ?? $this->otros_documentos,
                 'abonos' => $datos['abonos'] ?? $this->abonos,
             ]);
             $this->save();
         } else {
             abort(403, 'No tienes permisos para modificar estos campos.');
         }
     }
}

