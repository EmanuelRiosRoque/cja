<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presentador_tema', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tema_id');
            $table->unsignedBigInteger('presentador_id');
            $table->boolean('es_principal')->default(false); // opcional
            $table->timestamps();

            $table->foreign('tema_id')
                ->references('id')
                ->on('temas')
                ->onDelete('cascade');

            $table->foreign('presentador_id')
                ->references('id')
                ->on('presentadores')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presentador_tema');
    }
};
