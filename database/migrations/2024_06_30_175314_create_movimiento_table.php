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
        Schema::create('movimientos_caja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caja_id');
            $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_id'); // Usuario que realizó el movimiento
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('tipo', ['entrada', 'salida']);
            $table->decimal('monto_bolivares', 15, 2)->default(0);
            $table->decimal('monto_dolares', 15, 2)->default(0);
            $table->string('descripcion')->nullable(); // Descripción del movimiento
            $table->timestamp('fecha')->useCurrent(); // Fecha y hora del movimiento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaccions');
    }
};
