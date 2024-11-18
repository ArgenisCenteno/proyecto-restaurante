<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAperturaCajaToCierresCajaTable extends Migration
{
    public function up()
    {
        Schema::table('cierres_caja', function (Blueprint $table) {
            $table->unsignedBigInteger('apertura_caja')->nullable()->after('discrepancia_dolares'); // Ajusta la posición si es necesario
        });
    }

    public function down()
    {
        Schema::table('cierres_caja', function (Blueprint $table) {
            $table->dropColumn('apertura_caja');
        });
    }
}
