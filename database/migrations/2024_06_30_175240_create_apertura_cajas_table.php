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
        Schema::create('aperturas_caja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caja_id');
            $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_id'); // Usuario que abrió la caja
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('monto_inicial_bolivares', 15, 2)->default(0);
            $table->decimal('monto_inicial_dolares', 15, 2)->default(0);
            $table->timestamp('apertura')->useCurrent(); // Fecha y hora de apertura
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apertura_cajas');
    }
};
