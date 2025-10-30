<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ponencias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ejemplo: Ponencia 1, Secretaría Ejecutiva, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ponencias');
    }
};
