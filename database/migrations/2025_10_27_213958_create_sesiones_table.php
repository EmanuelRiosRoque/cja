<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesiones', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 10)->nullable()->unique();
            $table->integer('forma_captura');           

            $table->foreignId('sede_id')->constrained('sedes')->cascadeOnDelete();
            $table->foreignId('tipo_sesion_id')->constrained('tipos_sesion')->cascadeOnDelete();
            $table->foreignId('caracter_id')->constrained('caracteres_sesion')->cascadeOnDelete();

            $table->foreignId('estatus_id')
                ->default(1) 
                ->constrained('estatus')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->date('fecha_programada');
            $table->time('hora_programada');
            $table->time('hora_termino');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
