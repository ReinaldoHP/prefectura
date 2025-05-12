<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            $table->string('tipo_documento');        // cc, ce, nit, ti
            $table->string('numero_documento')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('municipio');
            $table->string('departamento');
            $table->string('direccion');
            $table->string('celular');
            $table->string('correo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
