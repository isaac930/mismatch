<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_replies', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->text('name');
            $table->text('contact');
            $table->text('email');
            $table->text('chatment_email');
            $table->text('chatment_name');
            $table->text('chatment_contact');
            $table->text('post');
            $table->text('reply_post');
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
        Schema::dropIfExists('chat_replies');
    }
}
