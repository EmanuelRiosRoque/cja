<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesion_id');
            
            $table->integer('numero_tema');
            $table->text('descripcion');
            $table->integer('prioridad')->default(1);
            $table->boolean('es_asunto_adicional')->default(false);
            $table->timestamps();

            $table->foreign('sesion_id')
                ->references('id')
                ->on('sesiones')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temas');
    }
};
