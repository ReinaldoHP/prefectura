<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->string('ciudad')->nullable();
            $table->date('fecha')->nullable();
            $table->string('recibido_de')->nullable();
            $table->string('direccion')->nullable();
            $table->string('cc')->nullable();
            $table->string('telefono')->nullable();
            $table->string('suma_letras')->nullable();
            $table->string('concepto')->nullable();
            $table->string('marca')->nullable();
            $table->string('linea')->nullable();
            $table->string('color')->nullable();
            $table->enum('forma_pago', ['Efectivo', 'Otro'])->default('Efectivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibos');
    }
};
