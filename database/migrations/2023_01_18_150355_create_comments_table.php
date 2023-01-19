<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_comment'); // comment by someone
            $table->bigInteger('post_comment'); // comment to the content
            $table->string('description');
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('user_comment')
                ->references('id')->on('users');
            $table->foreign('post_comment')
                ->references('id')->on('posts');
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
        Schema::dropIfExists('comments');
    }
};
