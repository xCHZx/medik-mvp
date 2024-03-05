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
            $table->string('objective');
            $table->text('alias');
            $table->boolean('isActive'); // para activar el flujo o desactivarlo segun el usuario decida
            $table->unsignedBigInteger('businessId');
            $table->boolean('isDeleted')->default(false);
            $table->string('hashedId')->nullable()->unique();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flows');
    }
};
