<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVentaIdToCuentasPorCobrarTable extends Migration
{
    public function up()
    {
        Schema::table('cuentas_por_cobrar', function (Blueprint $table) {
            $table->unsignedBigInteger('venta_id')->nullable()->after('pago_id');
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('cuentas_por_cobrar', function (Blueprint $table) {
            $table->dropForeign(['venta_id']);
            $table->dropColumn('venta_id');
        });
    }
}
