<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            $table->rememberToken()->nullable();
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

        // Seed the hourly_algorithms table
        DB::table('hourly_algorithms')->insert([
            ['title' => 'Binary Search', 'markdown' => 'Binary Search is a search algorithm that finds the position of a target value within a sorted array.'],
            ['title' => 'Bubble Sort', 'markdown' => 'Bubble Sort is a simple sorting algorithm that repeatedly steps through the list, compares adjacent elements and swaps them if they are in the wrong order.'],
            ['title' => 'Merge Sort', 'markdown' => 'Merge Sort is a divide and conquer algorithm that divides the input array into two halves, calls itself for the two halves, and then merges the two sorted halves.'],
            ['title' => 'Quick Sort', 'markdown' => 'Quick Sort is a divide and conquer algorithm that picks an element as pivot and partitions the given array around the picked pivot.'],
            ['title' => 'Selection Sort', 'markdown' => 'Selection Sort is a simple sorting algorithm that divides the input list into two parts: the sublist of items already sorted and the sublist of items remaining to be sorted.'],
            ['title' => 'Insertion Sort', 'markdown' => 'Insertion Sort is a simple sorting algorithm that builds the final sorted array one item at a time.'],
            ['title' => 'Heap Sort', 'markdown' => 'Heap Sort is a comparison-based sorting algorithm that creates a binary heap from the input array and then repeatedly extracts the maximum element from the heap and rebuilds the heap.'],
            ['title' => 'Counting Sort', 'markdown' => 'Counting Sort is an integer sorting algorithm that sorts the elements by counting the number of occurrences of each unique element in the input array.'],
            ['title' => 'Binary Search', 'markdown' => 'Binary Search is a search algorithm that finds the position of a target value within a sorted array.'],
            ['title' => 'Bubble Sort', 'markdown' => 'Bubble Sort is a simple sorting algorithm that repeatedly steps through the list, compares adjacent elements and swaps them if they are in the wrong order.'],
            ['title' => 'Merge Sort', 'markdown' => 'Merge Sort is a divide and conquer algorithm that divides the input array into two halves, calls itself for the two halves, and then merges the two sorted halves.'],
            ['title' => 'Quick Sort', 'markdown' => 'Quick Sort is a divide and conquer algorithm that picks an element as pivot and partitions the given array around the picked pivot.'],
            ['title' => 'Selection Sort', 'markdown' => 'Selection Sort is a simple sorting algorithm that divides the input list into two parts: the sublist of items already sorted and the sublist of items remaining to be sorted.'],
            ['title' => 'Insertion Sort', 'markdown' => 'Insertion Sort is a simple sorting algorithm that builds the final sorted array one item at a time.'],
            ['title' => 'Heap Sort', 'markdown' => 'Heap Sort is a comparison-based sorting algorithm that creates a binary heap from the input array and then repeatedly extracts the maximum element from the heap and rebuilds the heap.'],
            ['title' => 'Counting Sort', 'markdown' => 'Counting Sort is an integer sorting algorithm that sorts the elements by counting the number of occurrences of each unique element in the input array.'],
            ['title' => 'Binary Search', 'markdown' => 'Binary Search is a search algorithm that finds the position of a target value within a sorted array.'],
            ['title' => 'Bubble Sort', 'markdown' => 'Bubble Sort is a simple sorting algorithm that repeatedly steps through the list, compares adjacent elements and swaps them if they are in the wrong order.'],
            ['title' => 'Merge Sort', 'markdown' => 'Merge Sort is a divide and conquer algorithm that divides the input array into two halves, calls itself for the two halves, and then merges the two sorted halves.'],
            ['title' => 'Quick Sort', 'markdown' => 'Quick Sort is a divide and conquer algorithm that picks an element as pivot and partitions the given array around the picked pivot.'],
            ['title' => 'Selection Sort', 'markdown' => 'Selection Sort is a simple sorting algorithm that divides the input list into two parts: the sublist of items already sorted and the sublist of items remaining to be sorted.'],
            ['title' => 'Insertion Sort', 'markdown' => 'Insertion Sort is a simple sorting algorithm that builds the final sorted array one item at a time.'],
            ['title' => 'Heap Sort', 'markdown' => 'Heap Sort is a comparison-based sorting algorithm that creates a binary heap from the input array and then repeatedly extracts the maximum element from the heap and rebuilds the heap.'],
            ['title' => 'Counting Sort', 'markdown' => 'Counting Sort is an integer sorting algorithm that sorts the elements by counting the number of occurrences of each unique element in the input array.'],
        ]);

        // Seed the lessons table
        DB::table('lessons')->insert([
            ['title' => 'Algorithms'],
            ['title' => 'Data Structures'],
            ['title' => 'Web Development'],
        ]);

        // Seed the sublessons table
        DB::table('sublessons')->insert([
            ['lesson_id' => 1, 'title' => 'Binary Search', 'markdown' => 'Binary Search is a search algorithm that finds the position of a target value within a sorted array.', 'has_quiz' => false],
            ['lesson_id' => 1, 'title' => 'Bubble Sort', 'markdown' => 'Bubble Sort is a simple sorting algorithm that repeatedly steps through the list, compares adjacent elements and swaps them if they are in the wrong order.', 'has_quiz' => true],
            ['lesson_id' => 2, 'title' => 'Merge Sort', 'markdown' => 'Merge Sort is a divide and conquer algorithm that divides the input array into two halves, calls itself for the two halves, and then merges the two sorted halves.', 'has_quiz' => false],
            ['lesson_id' => 2, 'title' => 'Quick Sort', 'markdown' => 'Quick Sort is a divide and conquer algorithm that picks an element as pivot and partitions the given array around the picked pivot.', 'has_quiz' => false],
            ['lesson_id' => 2, 'title' => 'Selection Sort', 'markdown' => 'Selection Sort is a simple sorting algorithm that divides the input list into two parts: the sublist of items already sorted and the sublist of items remaining to be sorted.', 'has_quiz' => true],
            ['lesson_id' => 3, 'title' => 'Insertion Sort', 'markdown' => 'Insertion Sort is a simple sorting algorithm that builds the final sorted array one item at a time.', 'has_quiz' => false],
            ['lesson_id' => 3, 'title' => 'Heap Sort', 'markdown' => 'Heap Sort is a comparison-based sorting algorithm that creates a binary heap from the input array and then repeatedly extracts the maximum element from the heap and rebuilds the heap.', 'has_quiz' => false],
            ['lesson_id' => 3, 'title' => 'Counting Sort', 'markdown' => 'Counting Sort is an integer sorting algorithm that sorts the elements by counting the number of occurrences of each unique element in the input array.', 'has_quiz' => true],
        ]);

        // Seed the assignments table
        DB::table('assignments')->insert([
            ['sublesson_id' => 2, 'title' => 'Bubble Sort', 'markdown' => 'Bubble Sort is a simple sorting algorithm that repeatedly steps through the list, compares adjacent elements and swaps them if they are in the wrong order.', 'assignment_xp' => 100],
            ['sublesson_id' => 5, 'title' => 'Selection Sort', 'markdown' => 'Selection Sort is a simple sorting algorithm that divides the input list into two parts: the sublist of items already sorted and the sublist of items remaining to be sorted.', 'assignment_xp' => 100],
            ['sublesson_id' => 8, 'title' => 'Counting Sort', 'markdown' => 'Counting Sort is an integer sorting algorithm that sorts the elements by counting the number of occurrences of each unique element in the input array.', 'assignment_xp' => 100],
        ]);

        // Seed the tasks table, 4 tasks for each assignment, types are result (text input), checkbox, quiz (radio button), and true_false (radio button but only 2 options)
        DB::table('tasks')->insert([
            ['assignment_id' => 1, 'type' => 'result', 'title' => 'What is the time complexity of Bubble Sort?', 'markdown' => 'O(n^2)'],
            ['assignment_id' => 1, 'type' => 'checkbox', 'title' => 'Which of the following is true about Bubble Sort?', 'markdown' => 'It is stable, It is not adaptive, It is not a comparison-based algorithm, It is not an in-place sorting algorithm'],
            ['assignment_id' => 1, 'type' => 'quiz', 'title' => 'What is the worst-case time complexity of Bubble Sort?', 'markdown' => 'O(n^2), O(n log n), O(n), O(log n)'],
            ['assignment_id' => 1, 'type' => 'true_false', 'title' => 'Bubble Sort is a stable sorting algorithm.', 'markdown' => 'True, False'],
            ['assignment_id' => 2, 'type' => 'result', 'title' => 'What is the time complexity of Selection Sort?', 'markdown' => 'O(n^2)'],
            ['assignment_id' => 2, 'type' => 'checkbox', 'title' => 'Which of the following is true about Selection Sort?', 'markdown' => 'It is stable, It is not adaptive, It is not a comparison-based algorithm, It is not an in-place sorting algorithm'],
            ['assignment_id' => 2, 'type' => 'quiz', 'title' => 'What is the worst-case time complexity of Selection Sort?', 'markdown' => 'O(n^2), O(n log n), O(n), O(log n)'],
            ['assignment_id' => 2, 'type' => 'true_false', 'title' => 'Selection Sort is a stable sorting algorithm.', 'markdown' => 'True, False'],
            ['assignment_id' => 3, 'type' => 'result', 'title' => 'What is the time complexity of Counting Sort?', 'markdown' => 'O(n + k)'],
            ['assignment_id' => 3, 'type' => 'checkbox', 'title' => 'Which of the following is true about Counting Sort?', 'markdown' => 'It is stable, It is not adaptive, It is not a comparison-based algorithm, It is not an in place sorting algorithm'],
            ['assignment_id' => 3, 'type' => 'quiz', 'title' => 'What is the worst-case time complexity of Counting Sort?', 'markdown' => 'O(n^2), O(n log n), O(n), O(log n)'],
            ['assignment_id' => 3, 'type' => 'true_false', 'title' => 'Counting Sort is a stable sorting algorithm.', 'markdown' => 'True, False'],
        ]);

        // Seed the questions table
        DB::table('questions')->insert([
            ['task_id' => 1, 'markdown' => 'What is the time complexity of Bubble Sort?'],
            ['task_id' => 2, 'markdown' => 'Which of the following is true about Bubble Sort?'],
            ['task_id' => 3, 'markdown' => 'What is the worst-case time complexity of Bubble Sort?'],
            ['task_id' => 4, 'markdown' => 'Bubble Sort is a stable sorting algorithm.'],
            ['task_id' => 5, 'markdown' => 'What is the time complexity of Selection Sort?'],
            ['task_id' => 6, 'markdown' => 'Which of the following is true about Selection Sort?'],
            ['task_id' => 7, 'markdown' => 'What is the worst-case time complexity of Selection Sort?'],
            ['task_id' => 8, 'markdown' => 'Selection Sort is a stable sorting algorithm.'],
            ['task_id' => 9, 'markdown' => 'What is the time complexity of Counting Sort?'],
            ['task_id' => 10, 'markdown' => 'Which of the following is true about Counting Sort?'],
            ['task_id' => 11, 'markdown' => 'What is the worst-case time complexity of Counting Sort?'],
            ['task_id' => 12, 'markdown' => 'Counting Sort is a stable sorting algorithm.'],
        ]);

        // Seed the answers table
        DB::table('answers')->insert([
            ['question_id' => 1, 'answer' => 'O(n^2)', 'is_correct' => true],
            ['question_id' => 2, 'answer' => 'It is stable', 'is_correct' => false],
            ['question_id' => 2, 'answer' => 'It is not adaptive', 'is_correct' => false],
            ['question_id' => 2, 'answer' => 'It is a comparison-based algorithm', 'is_correct' => true],
            ['question_id' => 2, 'answer' => 'It is not an in-place sorting algorithm', 'is_correct' => false],
            ['question_id' => 3, 'answer' => 'O(n^2)', 'is_correct' => true],
            ['question_id' => 4, 'answer' => 'False', 'is_correct' => true],
            ['question_id' => 4, 'answer' => 'True', 'is_correct' => false],
            ['question_id' => 5, 'answer' => 'O(n^2)', 'is_correct' => true],
            ['question_id' => 6, 'answer' => 'It is not stable', 'is_correct' => true],
            ['question_id' => 6, 'answer' => 'It is not adaptive', 'is_correct' => false],
            ['question_id' => 6, 'answer' => 'It is not a comparison-based algorithm', 'is_correct' => false],
            ['question_id' => 6, 'answer' => 'It is not an in-place sorting algorithm', 'is_correct' => false],
            ['question_id' => 7, 'answer' => 'O(n^2)', 'is_correct' => true],
            ['question_id' => 8, 'answer' => 'False', 'is_correct' => true],
            ['question_id' => 8, 'answer' => 'True', 'is_correct' => false],
            ['question_id' => 9, 'answer' => 'O(n + k)', 'is_correct' => true],
            ['question_id' => 10, 'answer' => 'It is stable', 'is_correct' => false],
            ['question_id' => 10, 'answer' => 'It is not adaptive', 'is_correct' => false],
            ['question_id' => 10, 'answer' => 'It is not a comparison-based algorithm', 'is_correct' => false],
            ['question_id' => 10, 'answer' => 'It is not an in-place sorting algorithm', 'is_correct' => true],
            ['question_id' => 11, 'answer' => 'O(n + k)', 'is_correct' => true],
            ['question_id' => 12, 'answer' => 'False', 'is_correct' => true],
            ['question_id' => 12, 'answer' => 'True', 'is_correct' => false],
        ]);

        DB::table('users')->insert([
            [
                'name' => 'User One',
                'username' => 'userone',
                'email' => 'userone@inf.elte.hu',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'total_xp' => 0,
                'is_online' => false,
                'avatar' => 'default.png',
            ],
            [
                'name' => 'User Two',
                'username' => 'usertwo',
                'email' => 'usertwo@inf.elte.hu',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'total_xp' => 0,
                'is_online' => false,
                'avatar' => 'default.png',
            ],
            [
                'name' => 'User Three',
                'username' => 'userthree',
                'email' => 'userthree@inf.elte.hu',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'total_xp' => 0,
                'is_online' => false,
                'avatar' => 'default.png',
            ],
            [
                'name' => 'User Four',
                'username' => 'userfour',
                'email' => 'userfour@inf.elte.hu',
                'password' => Hash::make('password'),
                'total_xp' => 0,
                'is_online' => false,
                'avatar' => 'default.png',
            ],
        ]);

        DB::table('friendships')->insert([
            ['party1' => 1, 'party2' => 2],
        ]);

        DB::table('friend_requests')->insert([
            ['sender_id' => 1, 'receiver_id' => 3],
            ['sender_id' => 3, 'receiver_id' => 2],
        ]);

        DB::table('attempts')->insert([
            ['user_id' => 1, 'assignment_id' => 1, 'total_score' => 2, 'max_score' => 4, 'time' => '00:10:00', 'passed' => false],
            ['user_id' => 1, 'assignment_id' => 1, 'total_score' => 3, 'max_score' => 4, 'time' => '00:10:00', 'passed' => true],
            ['user_id' => 2, 'assignment_id' => 1, 'total_score' => 2, 'max_score' => 4, 'time' => '00:10:00', 'passed' => false],
            ['user_id' => 2, 'assignment_id' => 1, 'total_score' => 3, 'max_score' => 4, 'time' => '00:10:00', 'passed' => true],
        ]);

        DB::table('task_attempts')->insert([
            // User 1, attempt 1
            ['attempt_id' => 1, 'task_id' => 1],
            ['attempt_id' => 1, 'task_id' => 2],
            ['attempt_id' => 1, 'task_id' => 3],
            ['attempt_id' => 1, 'task_id' => 4],
            // User 1, attempt 2
            ['attempt_id' => 2, 'task_id' => 1],
            ['attempt_id' => 2, 'task_id' => 2],
            ['attempt_id' => 2, 'task_id' => 3],
            ['attempt_id' => 2, 'task_id' => 4],
            // User 2, attempt 1
            ['attempt_id' => 3, 'task_id' => 1],
            ['attempt_id' => 3, 'task_id' => 2],
            ['attempt_id' => 3, 'task_id' => 3],
            ['attempt_id' => 3, 'task_id' => 4],
            // User 2, attempt 2
            ['attempt_id' => 4, 'task_id' => 1],
            ['attempt_id' => 4, 'task_id' => 2],
            ['attempt_id' => 4, 'task_id' => 3],
            ['attempt_id' => 4, 'task_id' => 4],
        ]);

        DB::table('attempt_questions')->insert([
            // User 1, attempt 1 questions
            ['task_attempt_id' => 1, 'question_id' => 1],
            ['task_attempt_id' => 2, 'question_id' => 2],
            ['task_attempt_id' => 3, 'question_id' => 3],
            ['task_attempt_id' => 4, 'question_id' => 4],
            // User 1, attempt 2 questions
            ['task_attempt_id' => 5, 'question_id' => 1],
            ['task_attempt_id' => 6, 'question_id' => 2],
            ['task_attempt_id' => 7, 'question_id' => 3],
            ['task_attempt_id' => 8, 'question_id' => 4],
            // User 2, attempt 1 questions
            ['task_attempt_id' => 9, 'question_id' => 1],
            ['task_attempt_id' => 10, 'question_id' => 2],
            ['task_attempt_id' => 11, 'question_id' => 3],
            ['task_attempt_id' => 12, 'question_id' => 4],
            // User 2, attempt 2 questions
            ['task_attempt_id' => 13, 'question_id' => 1],
            ['task_attempt_id' => 14, 'question_id' => 2],
            ['task_attempt_id' => 15, 'question_id' => 3],
            ['task_attempt_id' => 16, 'question_id' => 4],
        ]);

        DB::table('attempt_answers')->insert([
            // User 1, attempt 1 answers (2/4)
            ['attempt_question_id' => 1, 'answer_id' => 1, 'custom_answer' => 'O(n^2)'], //correct
            ['attempt_question_id' => 2, 'answer_id' => 4, 'custom_answer' => ''], //correct
            ['attempt_question_id' => 3, 'answer_id' => 5, 'custom_answer' => 'O(n)'], //incorrect
            ['attempt_question_id' => 4, 'answer_id' => 8, 'custom_answer' => ''], //incorrect
            // User 1, attempt 2 answers (3/4)
            ['attempt_question_id' => 5, 'answer_id' => 1, 'custom_answer' => 'O(n^2)'], //correct
            ['attempt_question_id' => 6, 'answer_id' => 4, 'custom_answer' => ''], //correct
            ['attempt_question_id' => 7, 'answer_id' => 5, 'custom_answer' => 'O(n)'], //incorrect
            ['attempt_question_id' => 8, 'answer_id' => 7, 'custom_answer' => ''], //correct
            // User 2, attempt 1 answers (1/4)
            ['attempt_question_id' => 9, 'answer_id' => 1, 'custom_answer' => 'O(n^2)'],
            ['attempt_question_id' => 10, 'answer_id' => 3, 'custom_answer' => ''], //incorrect
            ['attempt_question_id' => 11, 'answer_id' => 5, 'custom_answer' => 'O(n)'], //incorrect
            ['attempt_question_id' => 12, 'answer_id' => 8, 'custom_answer' => ''], //incorrect
            // User 2, attempt 2 answers (3/4)
            ['attempt_question_id' => 13, 'answer_id' => 1, 'custom_answer' => 'O(n^2)'], //correct
            ['attempt_question_id' => 14, 'answer_id' => 4, 'custom_answer' => ''], //correct
            ['attempt_question_id' => 15, 'answer_id' => 5, 'custom_answer' => 'O(n)'], //incorrect
            ['attempt_question_id' => 16, 'answer_id' => 7, 'custom_answer' => ''], //correct
        ]);

        DB::table('successful_attempts')->insert([
            ['user_id' => 1, 'assignment_id' => 1, 'attempt_id' => 2],
            ['user_id' => 2, 'assignment_id' => 1, 'attempt_id' => 4],
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
