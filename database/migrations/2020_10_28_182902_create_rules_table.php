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
            $table->integer('match_duration')->nullable();
            $table->integer('number_of_qualifiers')->nullable();
            $table->integer('number_of_descending')->nullable();
            $table->enum('case_of_draw', ['draw', 'additional_time', 'penalties']);
            $table->integer('priority')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('competition_id')->nullable();
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
