<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Faq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->string('question', 255);
            $table->text('answer');
            $table->integer('order_to_display');
            $table->dateTime('updated_at');
            $table->dateTime('created_at');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('faqs');

    }
}
