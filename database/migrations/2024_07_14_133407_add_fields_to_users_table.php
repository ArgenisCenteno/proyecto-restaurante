<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dni')->nullable();
            $table->string('sector')->nullable();
            $table->string('calle')->nullable();
            $table->string('casa')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('dni');
            $table->dropColumn('sector');
            $table->dropColumn('calle');
            $table->dropColumn('casa');
            $table->dropColumn('status');
        });
    }
}
