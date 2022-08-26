<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaypalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paypal', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('amount');
        });
    }
}
