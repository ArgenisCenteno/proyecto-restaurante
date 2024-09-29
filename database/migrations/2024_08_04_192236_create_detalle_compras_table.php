<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleComprasTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->decimal('precio_producto', 10, 2);
            $table->integer('cantidad');
            $table->decimal('neto', 10, 2);
            $table->decimal('impuesto', 10, 2);
            $table->unsignedBigInteger('id_compra');
            $table->timestamps();

            // Índices y llaves foráneas si es necesario
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('id_compra')->references('id')->on('compras')->onDelete('cascade');
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_compras');
    }
}
