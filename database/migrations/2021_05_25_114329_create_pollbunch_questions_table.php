<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollbunchQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pollbunch_questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pollbunch_id')->unsigned();
            $table->string('text');
            $table->boolean('multiple');
            $table->string('vk_poll_id');
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
        Schema::dropIfExists('pollbunch_questions');
    }
}
