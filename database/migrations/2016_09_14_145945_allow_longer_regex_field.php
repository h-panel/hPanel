<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowLongerRegexField extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('service_variables', function (Blueprint $table) {
            $table->text('regex')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('service_variables', function (Blueprint $table) {
            $table->string('regex')->change();
        });
    }
}
