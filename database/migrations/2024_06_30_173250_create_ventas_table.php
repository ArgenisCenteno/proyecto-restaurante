<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendedor_id');
            $table->decimal('monto_total', 10, 2);
            $table->string('status');
            $table->decimal('porcentaje_descuento', 5, 2)->nullable();
            $table->unsignedBigInteger('pago_id')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vendedor_id')->references('id')->on('users');
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
