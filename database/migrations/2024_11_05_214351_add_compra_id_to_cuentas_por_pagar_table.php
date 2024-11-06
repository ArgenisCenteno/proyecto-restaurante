<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompraIdToCuentasPorPagarTable extends Migration
{
    public function up()
    {
        Schema::table('cuentas_por_pagar', function (Blueprint $table) {
            $table->unsignedBigInteger('compra_id')->nullable();
            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('cuentas_por_pagar', function (Blueprint $table) {
            $table->dropForeign(['compra_id']);
            $table->dropColumn('compra_id');
        });
    }
}
