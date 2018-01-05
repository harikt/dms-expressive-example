<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_groups', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->string('namespace', 255);
            $table->string('name', 255);
            $table->integer('order_index');
            $table->dateTime('updated_at');

            $table->index('parent_id', 'IDX_985B49DC727ACA70');
        });

        Schema::create('content_group_html_areas', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('content_group_id')->unsigned();
            $table->string('name', 100);
            $table->text('html');

            $table->unique(['content_group_id', 'name'], 'content_group_html_unique_index');
            $table->index('content_group_id', 'IDX_87B6C2F3ACE333A8');
        });

        Schema::create('content_group_image_areas', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('content_group_id')->unsigned();
            $table->string('name', 100);
            $table->string('image_path', 500);
            $table->string('client_file_name', 255)->nullable();
            $table->string('alt_text', 1000)->nullable();

            $table->unique(['content_group_id', 'name'], 'content_group_images_unique_index');
            $table->index('content_group_id', 'IDX_39468675ACE333A8');
        });

        Schema::create('content_group_text_areas', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('content_group_id')->unsigned();
            $table->string('name', 100);
            $table->text('text');

            $table->unique(['content_group_id', 'name'], 'content_group_text_unique_index');
            $table->index('content_group_id', 'IDX_61F51841ACE333A8');
        });

        Schema::create('content_group_file_areas', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('content_group_id')->unsigned();
            $table->string('name', 100);
            $table->string('file_path', 500);
            $table->string('client_file_name', 255)->nullable();

            $table->unique(['content_group_id', 'name'], 'content_group_file_unique_index');
            $table->index('content_group_id', 'IDX_9DC2122BACE333A8');
        });

        Schema::create('content_group_metadata', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('content_group_id')->unsigned();
            $table->string('name', 100);
            $table->string('value', 1000);

            $table->unique(['content_group_id', 'name'], 'content_group_metadata_unique_index');
            $table->index('content_group_id', 'IDX_2CCF82BFACE333A8');
        });

        Schema::table('content_groups', function (Blueprint $table) {
            $table->foreign('parent_id', 'fk_content_groups_parent_id_content_groups')
                    ->references('id')
                    ->on('content_groups')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::table('content_group_html_areas', function (Blueprint $table) {
            $table->foreign('content_group_id', 'fk_content_group_html_areas_content_group_id_content_groups')
                    ->references('id')
                    ->on('content_groups')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::table('content_group_image_areas', function (Blueprint $table) {
            $table->foreign('content_group_id', 'fk_content_group_image_areas_content_group_id_content_groups')
                    ->references('id')
                    ->on('content_groups')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::table('content_group_text_areas', function (Blueprint $table) {
            $table->foreign('content_group_id', 'fk_content_group_text_areas_content_group_id_content_groups')
                    ->references('id')
                    ->on('content_groups')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::table('content_group_file_areas', function (Blueprint $table) {
            $table->foreign('content_group_id', 'fk_content_group_file_areas_content_group_id_content_groups')
                    ->references('id')
                    ->on('content_groups')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::table('content_group_metadata', function (Blueprint $table) {
            $table->foreign('content_group_id', 'fk_content_group_metadata_content_group_id_content_groups')
                    ->references('id')
                    ->on('content_groups')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('content_group_metadata');
        Schema::drop('content_group_file_areas');
        Schema::drop('content_group_text_areas');
        Schema::drop('content_group_image_areas');
        Schema::drop('content_group_html_areas');
        Schema::drop('content_groups');

    }
}
