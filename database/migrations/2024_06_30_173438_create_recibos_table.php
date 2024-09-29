<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibosTable extends Migration
{
    public function up()
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->decimal('monto', 10, 2);
            $table->string('estatus');
            $table->unsignedBigInteger('pago_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('creado_id');
            $table->decimal('descuento', 10, 2)->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recibos');
    }
}
