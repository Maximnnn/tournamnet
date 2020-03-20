<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Plays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plays', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_id')->unsigned();
            $table->integer('play_type_id')->unsigned();
            $table->integer('step')->default(0);
            $table->integer('team_left')->unsigned();
            $table->integer('team_right')->unsigned();
            $table->integer('score_left')->unsigned()->default(0);
            $table->integer('score_right')->unsigned()->default(0);
            $table->boolean('finished')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plays');
    }
}
