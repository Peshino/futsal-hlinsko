<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('season_id')->nullable();
            $table->foreignId('competition_type_id')->nullable();
            $table->foreignId('competition_style_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->foreign('competition_type_id')->references('id')->on('competition_types')->onDelete('cascade');
            $table->foreign('competition_style_id')->references('id')->on('competition_styles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('competitions');
    }
}
