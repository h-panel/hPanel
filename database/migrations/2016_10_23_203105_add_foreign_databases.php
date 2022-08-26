<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignDatabases extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('databases', function (Blueprint $table) {
            $table->foreign('server_id')->references('id')->on('servers');
            $table->foreign('db_server')->references('id')->on('database_servers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('databases', function (Blueprint $table) {
            $table->dropForeign('databases_server_id_foreign');
            $table->dropForeign('databases_db_server_foreign');

            $table->dropIndex('databases_server_id_foreign');
            $table->dropIndex('databases_db_server_foreign');
        });
    }
}
