<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('status');
            $table->string('banco_origen');
            $table->string('banco_destino');
            $table->string('numero_referencia');
            $table->date('fecha_pago');
            $table->decimal('monto_total', 10, 2);
            $table->decimal('monto_neto', 10, 2);
            $table->decimal('descuento', 10, 2)->nullable();
            $table->decimal('tasa_dolar', 10, 2)->nullable();
            $table->string('forma_pago');
            $table->string('comprobante_archivo')->nullable();
            $table->unsignedBigInteger('creado_id');
            $table->decimal('porcentaje_descuento', 5, 2)->nullable();
            $table->decimal('impuestos', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
