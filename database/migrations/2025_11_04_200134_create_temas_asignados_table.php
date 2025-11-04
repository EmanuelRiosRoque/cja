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
        Schema::create('temas_asignados', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tema_id');

            // Llaves foráneas (si existen las tablas 'users' y 'temas')
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tema_id')->references('id')->on('temas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temas_asignados');
    }
};
