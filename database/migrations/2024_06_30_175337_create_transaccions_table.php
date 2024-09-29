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
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caja_id');
            $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_id'); // Usuario que realizó la venta
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('tipo', ['venta', 'devolucion', 'compra']);
            $table->decimal('monto_total_bolivares', 15, 2)->default(0);
            $table->decimal('monto_total_dolares', 15, 2)->default(0);
            $table->string('metodo_pago'); // Ejemplo: efectivo, punto, pago móvil
            $table->string('moneda'); // Ejemplo: bolívares, dólares
            $table->timestamp('fecha')->useCurrent(); // Fecha y hora de la transacción
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
