<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_short');
            $table->string('unique_code');
            $table->string('logo')->nullable();
            $table->string('web_presentation')->nullable();
            $table->foreignId('primary_color_id')->nullable();
            $table->foreignId('secondary_color_id')->nullable();
            $table->foreignId('superior_team_id')->nullable();
            $table->foreignId('inferior_team_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('competition_id');
            $table->foreign('primary_color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('secondary_color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('superior_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('inferior_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['name', 'competition_id']);

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
        Schema::dropIfExists('teams');
    }
}
