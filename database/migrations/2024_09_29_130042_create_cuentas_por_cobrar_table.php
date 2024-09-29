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
        Schema::create('cuentas_por_cobrar', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // Tipo de cuenta por cobrar
            $table->string('descripcion'); // Descripción de la cuenta
            $table->unsignedBigInteger('pago_id')->nullable(); // Pago relacionado, puede ser null
            $table->decimal('monto', 15, 2); // Monto
            $table->string('estado'); // Estado de la cuenta
            $table->timestamps();

            // Relación opcional a pagos
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas_por_cobrar');
    }
};
