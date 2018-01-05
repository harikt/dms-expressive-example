<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Blog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->boolean('published');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->unique('slug', 'blog_categories_slug_unique_index');
        });

        Schema::create('blog_authors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->string('name', 255);
            $table->string('role', 255);
            $table->string('slug', 255);
            $table->text('bio');

            $table->unique('slug', 'blog_authors_slug_unique_index');
        });

        Schema::create('blog_articles', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('blog_author_id')->unsigned();
            $table->integer('blog_category_id')->nullable()->unsigned();
            $table->string('title', 255);
            $table->string('sub_title', 255);
            $table->string('slug', 255);
            $table->text('extract');
            $table->string('featured_image', 500)->nullable();
            $table->string('featured_image_file_name', 255)->nullable();
            $table->date('date');
            $table->longText('article_content')->nullable();
            $table->boolean('allow_sharing');
            $table->boolean('allow_commenting');
            $table->boolean('published');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->unique('slug', 'blog_articles_slug_unique_index');
            $table->index('blog_category_id', 'IDX_CB80154FCB76011C');
            $table->index('blog_author_id', 'IDX_CB80154F530B1B54');
        });

        Schema::create('blog_article_comments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('blog_article_id')->unsigned();
            $table->string('author_name', 255);
            $table->string('author_email', 254);
            $table->text('content');
            $table->dateTime('posted_at');

            $table->index('blog_article_id', 'IDX_7E7549A79452A475');
        });

        Schema::table('blog_articles', function (Blueprint $table) {
            $table->foreign('blog_category_id', 'fk_blog_articles_blog_category_id_blog_categories')
                    ->references('id')
                    ->on('blog_categories')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            $table->foreign('blog_author_id', 'fk_blog_articles_blog_author_id_blog_authors')
                    ->references('id')
                    ->on('blog_authors')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::table('blog_article_comments', function (Blueprint $table) {
            $table->foreign('blog_article_id', 'fk_blog_article_comments_blog_article_id_blog_articles')
                    ->references('id')
                    ->on('blog_articles')
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
        Schema::drop('blog_article_comments');
        Schema::drop('blog_articles');
        Schema::drop('blog_authors');
        Schema::drop('blog_categories');

    }
}
