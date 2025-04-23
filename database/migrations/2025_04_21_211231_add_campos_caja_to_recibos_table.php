<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('recibos', function (Blueprint $table) {
        $table->decimal('valor_soat', 10, 2)->nullable();
        $table->decimal('valor_tecnomecanica', 10, 2)->nullable();
        $table->decimal('otros_documentos', 10, 2)->nullable();
        $table->decimal('abonos', 10, 2)->default(0);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recibos', function (Blueprint $table) {
            //
        });
    }
};
