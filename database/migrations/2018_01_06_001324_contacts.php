<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_enquiries', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->string('email', 254);
            $table->string('name', 255);
            $table->string('subject', 255);
            $table->string('message', 8000);
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
        Schema::drop('contact_enquiries');

    }
}
