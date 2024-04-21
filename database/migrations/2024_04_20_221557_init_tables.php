<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $ratingTypes = [
        ['name'=>'Дизайн', 'slug'=>'design', 'ord'=>1],
        ['name'=>'Юзабилити', 'slug'=>'usability', 'ord'=>2],
        ['name'=>'Верстка', 'slug'=>'layout', 'ord'=>3],
        ['name'=>'Реализация', 'slug'=>'realization', 'ord'=>4],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->string('slug', 100)->unique();
            $table->string('email', 150)->unique();
            $table->timestampTz('email_verified')->nullable();
            $table->string('login', 70)->unique();
            $table->string('password', 512);
            $table->string('icon_path', 256)->nullable();
        });

        Schema::create('team_users', function (Blueprint $table) {
            $table->id();
            $table->string('surname', 100);
            $table->string('first_name', 100);
            $table->string('patronymic')->nullable();
            $table->string('img_path')->nullable();
            $table->string('description', 255)->nullable();
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')
                ->on('teams')
                ->references('id')
                ->restrictOnDelete();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('fio', 255);
            $table->string('email', 150);
            $table->string('text');
            $table->unsignedBigInteger('team_user_id');
            $table->foreign('team_user_id')
                ->on('team_users')
                ->references('id')
                ->restrictOnDelete();
            $table->timestampsTz();
            $table->timestampTz('deleted_at')->nullable();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')
                ->on('questions')
                ->references('id')
                ->restrictOnDelete();
            $table->timestampsTz();
            $table->timestampTz('deleted_at')->nullable();
        });

        Schema::create('rating_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug')->unique();
            $table->integer('ord')->nullable();
        });

        Schema::create('rating', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')
                ->on('teams')
                ->references('id')
                ->restrictOnDelete();
            $table->unsignedBigInteger('rating_type_id');
            $table->foreign('rating_type_id')
                ->on('rating_types')
                ->references('id')
                ->restrictOnDelete();
            $table->integer('mark');
        });

        Schema::create('team_auths', function (Blueprint $table) {
            $table->id();
            $table->integer('team_id');
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('token', 512);
            $table->timestampTz('expires_at')->nullable();
            $table->timestampTz('created_at')->nullable();
            $table->timestampTz('deleted_at')->nullable();
        });

        DB::table('rating_types')->insert($this->ratingTypes);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_users', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['team_user_id']);
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
        });

        Schema::table('rating', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropForeign(['rating_type_id']);
        });

        Schema::table('team_auths', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });

        Schema::dropIfExists('team_auths');
        Schema::drop('teams');
        Schema::drop('team_users');
        Schema::drop('questions');
        Schema::drop('answers');
        Schema::drop('rating_types');
        Schema::drop('rating');
    }
};
