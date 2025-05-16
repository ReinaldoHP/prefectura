<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['moto_id']);
            $table->dropColumn('moto_id');
        });
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->unsignedBigInteger('moto_id')->nullable();
            $table->foreign('moto_id')->references('id')->on('motos')->onDelete('set null');
        });
    }

};
