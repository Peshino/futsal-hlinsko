<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('history_code');
            $table->integer('jersey_number')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('position', ['goalkeeper', 'defender', 'universal', 'forward'])->nullable();
            $table->string('photo')->nullable();
            $table->bigInteger('futis_code')->nullable();
            $table->integer('height')->nullable();
            $table->string('nationality')->nullable();
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->foreignId('competition_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
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
        Schema::dropIfExists('players');
    }
}
