<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaModelo extends Model
{
    protected $fillable = ['marca', 'modelo'];

    public function motos()
    {
        return $this->hasMany(Moto::class);
    }
}
