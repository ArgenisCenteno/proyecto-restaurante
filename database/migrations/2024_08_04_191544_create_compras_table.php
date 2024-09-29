<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id(); // Campo id auto incrementable
            $table->unsignedBigInteger('proveedor_id'); // Relación con la tabla proveedores
            $table->unsignedBigInteger('user_id'); // Relación con la tabla usuarios
            $table->decimal('monto_total', 10, 2); // Monto total de la compra
            $table->string('status'); // Estado de la compra
            $table->decimal('porcentaje_descuento', 5, 2)->nullable(); // Porcentaje de descuento
            $table->unsignedBigInteger('pago_id'); // Relación con la tabla pagos
            $table->timestamps(); // Campos created_at y updated_at

            // Definición de claves foráneas si es necesario
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('cascade');
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
