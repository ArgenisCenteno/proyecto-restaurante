<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->decimal('precio_producto', 10, 2);
            $table->integer('cantidad');
            $table->decimal('neto', 10, 2);
            $table->decimal('impuesto', 10, 2)->nullable();
            $table->unsignedBigInteger('id_venta');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->foreign('id_venta')->references('id')->on('ventas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
}
