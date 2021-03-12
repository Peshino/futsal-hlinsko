<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['main', 'qualification', 'descent', 'playoff']);
            $table->enum('system', ['one_rounded', 'two_rounded']);
            $table->integer('priority');
            $table->integer('number_of_rounds')->nullable();
            $table->integer('number_of_qualifiers')->nullable();
            $table->integer('number_of_descending')->nullable();
            $table->integer('game_duration')->nullable();
            $table->integer('points_for_win')->nullable();
            $table->integer('games_day_min')->nullable();
            $table->integer('games_day_max')->nullable();
            $table->integer('team_games_day_round_min')->nullable();
            $table->integer('team_games_day_round_max')->nullable();
            $table->json('game_days_times');
            $table->enum('case_of_draw', ['draw', 'additional_time', 'penalties']);
            $table->date('start_date');
            $table->date('end_date');
            $table->date('break_start_date')->nullable();
            $table->date('break_end_date')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('competition_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('rules');
    }
}
