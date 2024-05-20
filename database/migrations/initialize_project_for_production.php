<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sessions', static function ($table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity');
        });

        Schema::create('password_reset_tokens', static function ($table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('migrations', static function ($table) {
            $table->id();
            $table->string('migration');
            $table->integer('batch');
        });

        Schema::create('jobs', static function ($table) {
            $table->id();
            $table->string('queue');
            $table->longText('payload');
            $table->tinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', static function ($table) {
            $table->id();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options');
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at');
        });

        Schema::create('failed_jobs', static function ($table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('cache', static function ($table) {
            $table->string('key')->primary();
            $table->longText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', static function ($table) {
            $table->string('name')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        Schema::create('users', static function ($table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('total_xp')->default(0);
            $table->boolean('is_online')->default(false);
            $table->dateTime('last_online')->nullable();
            $table->string('avatar')->default('default.png');
            $table->string('last_seen_at')->nullable();
            $table->string('last_activity')->nullable();
        });

        Schema::create('levels', static function ($table) {
            $table->id()->autoIncrement();
            $table->integer('level');
            $table->integer('xp_start');
            $table->integer('xp_end');
            $table->timestamps();
        });

        Schema::create('friendships', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('party1');
            $table->foreignId('party2');
            $table->timestamps();
        });

        Schema::create('friend_requests', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('sender_id');
            $table->foreignId('receiver_id');
            $table->timestamps();
        });

        Schema::create('hourly_algorithms', static function ($table) {
            $table->id()->autoIncrement();
            $table->string('title');
            $table->text('markdown');
            $table->timestamps();
        });

        Schema::create('lessons', static function ($table) {
            $table->id()->autoIncrement();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('sublessons', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('lesson_id');
            $table->string('title');
            $table->text('markdown');
            $table->boolean('has_quiz')->default(false);
            $table->timestamps();
        });

        Schema::create('assignments', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('sublesson_id');
            $table->string('title');
            $table->text('markdown');
            $table->integer('assignment_xp');
            $table->timestamps();
        });

        Schema::create('tasks', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('assignment_id');
            $table->string('type');
            $table->string('title');
            $table->text('markdown');
            $table->timestamps();
        });

        Schema::create('questions', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('task_id');
            $table->text('markdown');
            $table->timestamps();
        });

        Schema::create('answers', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('question_id');
            $table->string('answer');
            $table->boolean('is_correct');
            $table->timestamps();
        });

        Schema::create('attempts', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('user_id');
            $table->foreignId('assignment_id');
            $table->integer('total_score');
            $table->integer('max_score');
            $table->time('time');
            $table->boolean('passed');
            $table->timestamps();
        });

        Schema::create('task_attempts', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('attempt_id');
            $table->foreignId('task_id');
            $table->timestamps();
        });

        Schema::create('attempt_questions', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('task_attempt_id');
            $table->foreignId('question_id');
            $table->timestamps();
        });

        Schema::create('attempt_answers', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('attempt_question_id');
            $table->foreignId('answer_id');
            $table->string('custom_answer');
            $table->timestamps();
        });

        Schema::create('successful_attempts', static function ($table) {
            $table->id()->autoIncrement();
            $table->foreignId('user_id');
            $table->foreignId('assignment_id');
            $table->foreignId('attempt_id');
            $table->timestamps();
        });

        // Seed the levels table
        DB::table('levels')->insert([
            ['level' => 1, 'xp_start' => 0, 'xp_end' => 100],
            ['level' => 2, 'xp_start' => 101, 'xp_end' => 200],
            ['level' => 3, 'xp_start' => 201, 'xp_end' => 300],
            ['level' => 4, 'xp_start' => 301, 'xp_end' => 400],
            ['level' => 5, 'xp_start' => 401, 'xp_end' => 500],
            ['level' => 6, 'xp_start' => 501, 'xp_end' => 600],
            ['level' => 7, 'xp_start' => 601, 'xp_end' => 700],
            ['level' => 8, 'xp_start' => 701, 'xp_end' => 800],
            ['level' => 9, 'xp_start' => 801, 'xp_end' => 900],
            ['level' => 10, 'xp_start' => 901, 'xp_end' => 1000],
            ['level' => 11, 'xp_start' => 1001, 'xp_end' => 1100],
            ['level' => 12, 'xp_start' => 1101, 'xp_end' => 1200],
            ['level' => 13, 'xp_start' => 1201, 'xp_end' => 1300],
            ['level' => 14, 'xp_start' => 1301, 'xp_end' => 1400],
            ['level' => 15, 'xp_start' => 1401, 'xp_end' => 1500],
            ['level' => 16, 'xp_start' => 1501, 'xp_end' => 1600],
            ['level' => 17, 'xp_start' => 1601, 'xp_end' => 1700],
            ['level' => 18, 'xp_start' => 1701, 'xp_end' => 1800],
            ['level' => 19, 'xp_start' => 1801, 'xp_end' => 1900],
            ['level' => 20, 'xp_start' => 1901, 'xp_end' => 2000],
            ['level' => 21, 'xp_start' => 2001, 'xp_end' => 2100],
            ['level' => 22, 'xp_start' => 2101, 'xp_end' => 2200],
            ['level' => 23, 'xp_start' => 2201, 'xp_end' => 2300],
            ['level' => 24, 'xp_start' => 2301, 'xp_end' => 2400],
            ['level' => 25, 'xp_start' => 2401, 'xp_end' => 2500],
            ['level' => 26, 'xp_start' => 2501, 'xp_end' => 2600],
            ['level' => 27, 'xp_start' => 2601, 'xp_end' => 2700],
            ['level' => 28, 'xp_start' => 2701, 'xp_end' => 2800],
            ['level' => 29, 'xp_start' => 2801, 'xp_end' => 2900],
            ['level' => 30, 'xp_start' => 2901, 'xp_end' => 3000],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('migrations');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('users');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('friendships');
        Schema::dropIfExists('friend_requests');
        Schema::dropIfExists('hourly_algorithms');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('sublessons');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('attempts');
        Schema::dropIfExists('task_attempts');
        Schema::dropIfExists('attempt_questions');
        Schema::dropIfExists('attempt_answers');
        Schema::dropIfExists('successful_attempts');
    }
};
