<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cuentas_por_pagar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('user_id');
            $table->string('tipo');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('pago_id')->nullable();
            $table->decimal('monto', 15, 2);
            $table->string('estado');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cuentas_por_pagar');
    }
};
