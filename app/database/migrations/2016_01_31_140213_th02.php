<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Th02 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('th02', function($table) {
            $table->increments('idph');
            $table->datetime('tglph');
            $table->bigInteger('nilph');
            $table->char('status', 1);
            $table->integer("idhut")->unsigned();
            $table->timestamps();
        });

        Schema::table('th02', function($table) {
            $table->foreign('idhut')->references('idhut')->on('th01');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('th02');
    }

}
