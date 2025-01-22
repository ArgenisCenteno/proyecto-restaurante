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
        Schema::create('pagos_cuentas_por_cobrar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuenta_por_cobrar_id');
            $table->unsignedBigInteger('pago_id');
            $table->decimal('monto_abono', 10, 2);
            $table->timestamps();

            // Foreign keys
            $table->foreign('cuenta_por_cobrar_id')
                ->references('id')
                ->on('cuentas_por_cobrar')
                ->onDelete('cascade');

            $table->foreign('pago_id')
                ->references('id')
                ->on('pagos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos_cuentas_por_cobrar');
    }
};
