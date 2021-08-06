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
            $table->string('history_code');
            $table->string('logo')->nullable();
            $table->string('web_presentation')->nullable();
            $table->foreignId('primary_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->foreignId('secondary_color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->foreignId('superior_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('inferior_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('competition_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('teams');
    }
}
