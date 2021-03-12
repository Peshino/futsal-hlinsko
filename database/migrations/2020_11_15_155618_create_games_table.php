<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('round');
            $table->dateTime('start_datetime');
            $table->foreignId('home_team_id');
            $table->foreignId('away_team_id');
            $table->integer('home_team_score')->nullable();
            $table->integer('away_team_score')->nullable();
            $table->integer('home_team_halftime_score')->nullable();
            $table->integer('away_team_halftime_score')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('rule_id');
            $table->foreignId('competition_id');
            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rule_id')->references('id')->on('rules')->onDelete('cascade');
            $table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
            $table->timestamps();

            $table->engine = 'InnoDB'; // if foreign keys are in use
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
