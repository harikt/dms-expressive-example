<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dms_roles', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->string('name', 255);

        });

        Schema::create('dms_users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->enum('type', ['local', 'oauth'])->comment('(DC2Type:CustomEnum__local__oauth)');
            $table->string('full_name', 255);
            $table->string('email', 254);
            $table->string('username', 255);
            $table->boolean('is_super_user');
            $table->boolean('is_banned');
            $table->string('password_hash', 255)->nullable();
            $table->string('password_algorithm', 10)->nullable();
            $table->integer('password_cost_factor')->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->string('oauth_provider_name', 255)->nullable();
            $table->string('oauth_account_id', 255)->nullable();
            $table->mediumText('metadata');

            $table->unique('email', 'dms_users_email_unique_index');
            $table->unique('username', 'dms_users_username_unique_index');
        });

        Schema::create('dms_user_roles', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('role_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->index('role_id', 'IDX_2F104DAD60322AC');
            $table->index('user_id', 'IDX_2F104DAA76ED395');
        });

        Schema::create('dms_permissions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->integer('role_id')->unsigned();
            $table->string('name', 255);

            $table->index('role_id', 'IDX_2B0D74A1D60322AC');
        });

        Schema::create('dms_password_resets', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->string('email', 255);
            $table->string('token', 255);
            $table->dateTime('created_at');

            $table->unique('token', 'dms_password_resets_token_unique_index');
        });

        Schema::create('dms_temp_files', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->string('token', 40);
            $table->text('file');
            $table->string('client_file_name', 255)->nullable();
            $table->enum('type', ['uploaded-image', 'uploaded-file', 'stored-image', 'in-memory', 'stored-file'])->comment('(DC2Type:CustomEnum__uploaded_image__uploaded_file__stored_image__in_memory__stored_file)');
            $table->dateTime('expiry_time');

            $table->unique('token', 'dms_temp_files_token_unique_index');
        });

        Schema::table('dms_user_roles', function (Blueprint $table) {
            $table->foreign('role_id', 'fk_dms_user_roles_role_id_dms_roles')
                    ->references('id')
                    ->on('dms_roles')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('user_id', 'fk_dms_user_roles_user_id_dms_users')
                    ->references('id')
                    ->on('dms_users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        Schema::table('dms_permissions', function (Blueprint $table) {
            $table->foreign('role_id', 'fk_dms_permissions_role_id_dms_roles')
                    ->references('id')
                    ->on('dms_roles')
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
        Schema::drop('dms_temp_files');
        Schema::drop('dms_password_resets');
        Schema::drop('dms_permissions');
        Schema::drop('dms_user_roles');
        Schema::drop('dms_users');
        Schema::drop('dms_roles');

    }
}
