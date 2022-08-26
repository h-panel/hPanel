<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowNullableDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eggs', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });

        Schema::table('nests', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });

        Schema::table('nodes', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->text('long')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eggs', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });

        Schema::table('nests', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });

        Schema::table('nodes', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->text('long')->nullable(false)->change();
        });
    }
}
