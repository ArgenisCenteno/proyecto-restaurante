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
       Schema::create('cierres_caja', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('caja_id');
    $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('cascade');
    $table->unsignedBigInteger('usuario_id'); // Usuario que cerró la caja
    $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
    $table->decimal('monto_final_bolivares', 15, 2);
    $table->decimal('monto_final_dolares', 15, 2);
    $table->decimal('discrepancia_bolivares', 15, 2)->default(0);
    $table->decimal('discrepancia_dolares', 15, 2)->default(0);
    $table->timestamp('cierre')->useCurrent(); // Fecha y hora de cierre
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre_cajas');
    }
};
