<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('group_id')->unsigned();
            $table->bigInteger('creator_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('vk_id');
            $table->text('text')->nullable()->default(null);
            $table->bigInteger('signer_id')->unsigned()->nullable()->default(null);
            $table->integer('points')->unsigned()->default(0);
            $table->bigInteger('points_assigner_id')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('posts');
    }
}
