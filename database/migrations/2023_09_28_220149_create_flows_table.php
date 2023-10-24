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
        Schema::create('flows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('objetivo'); 
            $table->boolean('isActive'); // para activar el flujo o desactivarlo segun el usuario decida
            $table->unsignedBigInteger('businessId')->unique();
            $table->timestamps();
        });

        // modificar los de waiting y forward para guardar milisegundos en vez de enteros
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flows');
    }
};
