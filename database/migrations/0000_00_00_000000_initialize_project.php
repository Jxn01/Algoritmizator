<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
            $table->foreignId('answer_id')->nullable();
            $table->string('custom_answer')->nullable();
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

        DB::table('lessons')->insert([
            ['title' => 'Adatszerkezetek'],
            ['title' => 'Rendező algoritmusok'],
            ['title' => 'Gráf algoritmusok'],
            ['title' => 'Memóriakezelés és pointerek'],
        ]);

        DB::table('sublessons')->insert([
            ['lesson_id' => 1, 'title' => 'Tömbök', 'markdown' => Storage::get('markdowns/lessons/data_structures/arrays.md'), 'has_quiz' => true],
            ['lesson_id' => 1, 'title' => 'Listák', 'markdown' => Storage::get('markdowns/lessons/data_structures/lists.md'), 'has_quiz' => true],
            ['lesson_id' => 1, 'title' => 'Vermek', 'markdown' => Storage::get('markdowns/lessons/data_structures/stacks.md'), 'has_quiz' => true],
            ['lesson_id' => 1, 'title' => 'Sorok', 'markdown' => Storage::get('markdowns/lessons/data_structures/queues.md'), 'has_quiz' => true],
            ['lesson_id' => 1, 'title' => 'Fák', 'markdown' => Storage::get('markdowns/lessons/data_structures/trees.md'), 'has_quiz' => true],
            ['lesson_id' => 1, 'title' => 'Gráfok', 'markdown' => Storage::get('markdowns/lessons/data_structures/graphs.md'), 'has_quiz' => true],
            ['lesson_id' => 1, 'title' => 'Hasító táblák', 'markdown' => Storage::get('markdowns/lessons/data_structures/hash_tables.md'), 'has_quiz' => true],

            ['lesson_id' => 2, 'title' => 'Beszúró rendezés', 'markdown' => Storage::get('markdowns/lessons/sorting_algorithms/insertion_sort.md'), 'has_quiz' => true],
            ['lesson_id' => 2, 'title' => 'Kiválasztó rendezés', 'markdown' => Storage::get('markdowns/lessons/sorting_algorithms/selection_sort.md'), 'has_quiz' => true],
            ['lesson_id' => 2, 'title' => 'Összefésülő rendezés', 'markdown' => Storage::get('markdowns/lessons/sorting_algorithms/merge_sort.md'), 'has_quiz' => true],
            ['lesson_id' => 2, 'title' => 'Gyors rendezés', 'markdown' => Storage::get('markdowns/lessons/sorting_algorithms/quick_sort.md'), 'has_quiz' => true],
            ['lesson_id' => 2, 'title' => 'Kupacrendezés', 'markdown' => Storage::get('markdowns/lessons/sorting_algorithms/heap_sort.md'), 'has_quiz' => true],
            ['lesson_id' => 2, 'title' => 'Edényrendezés', 'markdown' => Storage::get('markdowns/lessons/sorting_algorithms/bucket_sort.md'), 'has_quiz' => true],
            ['lesson_id' => 2, 'title' => 'Leszámláló rendezés', 'markdown' => Storage::get('markdowns/lessons/sorting_algorithms/counting_sort.md'), 'has_quiz' => true],
            ['lesson_id' => 2, 'title' => 'Radix rendezés', 'markdown' => Storage::get('markdowns/lessons/sorting_algorithms/radix_sort.md'), 'has_quiz' => true],

            ['lesson_id' => 3, 'title' => 'Gráfok ábrázolásai', 'markdown' => Storage::get('markdowns/lessons/graph_algorithms/graph_representations.md'), 'has_quiz' => true],
            ['lesson_id' => 3, 'title' => 'Szélességi bejárás', 'markdown' => Storage::get('markdowns/lessons/graph_algorithms/breadth_first_search.md'), 'has_quiz' => true],
            ['lesson_id' => 3, 'title' => 'Mélységi bejárás', 'markdown' => Storage::get('markdowns/lessons/graph_algorithms/depth_first_search.md'), 'has_quiz' => true],
            ['lesson_id' => 3, 'title' => 'Legrövidebb út algoritmusok', 'markdown' => Storage::get('markdowns/lessons/graph_algorithms/shortest_path_algorithms.md'), 'has_quiz' => true],

            ['lesson_id' => 4, 'title' => 'Mutatók', 'markdown' => Storage::get('markdowns/lessons/c/pointers.md'), 'has_quiz' => true],
            ['lesson_id' => 4, 'title' => 'Memóriakezelés', 'markdown' => Storage::get('markdowns/lessons/c/memory_management.md'), 'has_quiz' => true],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 1,
                'title' => 'Tömbök kezelése C++ nyelven - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/data_structures/arrays/arrays.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 1, 'type' => 'quiz', 'title' => 'Tömbök alapjai', 'markdown' => 'Ebben a részben a tömbök alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 1, 'type' => 'true_false', 'title' => 'Tömbök inicializálása és elérése', 'markdown' => 'Ebben a részben a tömbök inicializálásával és elemeik elérésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 1, 'type' => 'checkbox', 'title' => 'Dinamikus tömbök kezelése', 'markdown' => 'Ebben a részben a dinamikus tömbök kezelésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 1, 'type' => 'result', 'title' => 'Memóriakezelési gyakorlat', 'markdown' => Storage::get('markdowns/assignments/data_structures/arrays/code_task.md')],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 1, 'markdown' => 'Mi a tömbök szerepe a programozásban?'],
            ['task_id' => 1, 'markdown' => 'Hogyan hozhatunk létre egy statikus tömböt C++ nyelven?'],
            ['task_id' => 2, 'markdown' => 'A tömb elemeit automatikusan nullával inicializálják, ha statikusan hozzuk létre őket.'],
            ['task_id' => 2, 'markdown' => 'A tömb elemeit indexeléssel érhetjük el.'],
            ['task_id' => 3, 'markdown' => 'Mely függvények használhatóak dinamikus memória kezelésére C++ nyelven?'],
            ['task_id' => 3, 'markdown' => 'Melyik állítás igaz a malloc() függvényre?'],
            ['task_id' => 4, 'markdown' => 'Mi lesz a rendezett tömb kimenete a fenti műveletek után?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 1, 'answer' => 'Adatok csoportos tárolása', 'is_correct' => true],
            ['question_id' => 1, 'answer' => 'Egyetlen érték tárolása', 'is_correct' => false],
            ['question_id' => 1, 'answer' => 'Adatok rendezése', 'is_correct' => false],
            ['question_id' => 2, 'answer' => 'int arr[10];', 'is_correct' => true],
            ['question_id' => 2, 'answer' => 'int* arr = new int[10];', 'is_correct' => false],
            ['question_id' => 2, 'answer' => 'int arr = malloc(sizeof(int) * 10);', 'is_correct' => false],
            ['question_id' => 3, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 3, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 4, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 4, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 5, 'answer' => 'malloc()', 'is_correct' => true],
            ['question_id' => 5, 'answer' => 'calloc()', 'is_correct' => true],
            ['question_id' => 5, 'answer' => 'realloc()', 'is_correct' => true],
            ['question_id' => 5, 'answer' => 'free()', 'is_correct' => true],
            ['question_id' => 5, 'answer' => 'delete', 'is_correct' => false],
            ['question_id' => 5, 'answer' => 'new', 'is_correct' => false],
            ['question_id' => 6, 'answer' => 'Egy adott méretű memóriaterületet foglal le és visszaad egy pointert az első byte címére', 'is_correct' => true],
            ['question_id' => 6, 'answer' => 'Egy már lefoglalt memóriaterület méretét módosítja', 'is_correct' => false],
            ['question_id' => 6, 'answer' => 'Új memóriaterületet foglal és inicializálja nullával', 'is_correct' => false],
            ['question_id' => 7, 'answer' => '[5, 9, 6]', 'is_correct' => true],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 2,
                'title' => 'Listák kezelése programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/data_structures/lists/lists.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 2, 'type' => 'quiz', 'title' => 'Listák alapjai', 'markdown' => 'Ebben a részben a listák alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 2, 'type' => 'true_false', 'title' => 'Listák típusai', 'markdown' => 'Ebben a részben a listák különböző típusairól szóló kérdéseket találsz.'],
            ['assignment_id' => 2, 'type' => 'checkbox', 'title' => 'Lista műveletei', 'markdown' => 'Ebben a részben a lista különböző műveleteivel kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 2, 'type' => 'result', 'title' => 'Memóriakezelési gyakorlat', 'markdown' => Storage::get('markdowns/assignments/data_structures/lists/code_task.md')],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 5, 'markdown' => 'Mi a lista szerepe a programozásban?'],
            ['task_id' => 5, 'markdown' => 'Hogyan hozhatunk létre egy láncolt listát?'],
            ['task_id' => 6, 'markdown' => 'Az egyszeresen láncolt lista minden csomópontja tartalmaz egy elemet és egy hivatkozást a következő csomópontra.'],
            ['task_id' => 6, 'markdown' => 'A cirkuláris láncolt lista utolsó csomópontja az első csomópontra mutat.'],
            ['task_id' => 7, 'markdown' => 'Mely műveletek tartoznak a lista alapvető műveletei közé?'],
            ['task_id' => 7, 'markdown' => 'Melyik állítás igaz a lista keresési műveletére?'],
            ['task_id' => 8, 'markdown' => 'Mi lesz a lista tartalma a fenti műveletek után?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 8, 'answer' => 'Adatok sorozatának tárolása és kezelése', 'is_correct' => true],
            ['question_id' => 8, 'answer' => 'Csak számok tárolása', 'is_correct' => false],
            ['question_id' => 8, 'answer' => 'Csak karakterek tárolása', 'is_correct' => false],
            ['question_id' => 9, 'answer' => 'struct Node { int data; Node* next; };', 'is_correct' => true],
            ['question_id' => 9, 'answer' => 'int list[10];', 'is_correct' => false],
            ['question_id' => 9, 'answer' => 'Node* list = malloc(sizeof(Node) * 10);', 'is_correct' => false],
            ['question_id' => 10, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 10, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 11, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 11, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 12, 'answer' => 'Insert', 'is_correct' => true],
            ['question_id' => 12, 'answer' => 'Delete', 'is_correct' => true],
            ['question_id' => 12, 'answer' => 'Search', 'is_correct' => true],
            ['question_id' => 12, 'answer' => 'Sort', 'is_correct' => true],
            ['question_id' => 12, 'answer' => 'Print', 'is_correct' => false],
            ['question_id' => 13, 'answer' => 'Az elem megtalálása és a csomópont visszaadása', 'is_correct' => true],
            ['question_id' => 13, 'answer' => 'Az elem rendezése', 'is_correct' => false],
            ['question_id' => 13, 'answer' => 'A lista méretének növelése', 'is_correct' => false],
            ['question_id' => 14, 'answer' => '4 1 3', 'is_correct' => true],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 3,
                'title' => 'Vermek kezelése programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/data_structures/stacks/stacks.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 3, 'type' => 'quiz', 'title' => 'Vermek alapjai', 'markdown' => 'Ebben a részben a vermek alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 3, 'type' => 'true_false', 'title' => 'Vermek műveletei', 'markdown' => 'Ebben a részben a vermek különböző műveleteivel kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 3, 'type' => 'checkbox', 'title' => 'Vermek memóriakezelése', 'markdown' => 'Ebben a részben a vermek memóriakezelésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 3, 'type' => 'result', 'title' => 'Memóriakezelési gyakorlat', 'markdown' => Storage::get('markdowns/assignments/data_structures/stacks/code_task.md')],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 9, 'markdown' => 'Mi a verem szerepe a programozásban?'],
            ['task_id' => 9, 'markdown' => 'Hogyan hozhatunk létre egy veremet?'],
            ['task_id' => 10, 'markdown' => 'A verem elemeit LIFO (Last In, First Out) elv szerint kezeljük.'],
            ['task_id' => 10, 'markdown' => 'A verem elemeit FIFO (First In, First Out) elv szerint kezeljük.'],
            ['task_id' => 11, 'markdown' => 'Mely műveletek tartoznak a verem alapvető műveletei közé?'],
            ['task_id' => 11, 'markdown' => 'Melyik állítás igaz a verem memóriakezelésére?'],
            ['task_id' => 12, 'markdown' => 'Mi lesz a verem tartalma a fenti műveletek után?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 15, 'answer' => 'Adatok sorozatának LIFO elven történő kezelése', 'is_correct' => true],
            ['question_id' => 15, 'answer' => 'Adatok FIFO elven történő kezelése', 'is_correct' => false],
            ['question_id' => 15, 'answer' => 'Csak számok tárolása', 'is_correct' => false],
            ['question_id' => 16, 'answer' => 'stack<int> s;', 'is_correct' => true],
            ['question_id' => 16, 'answer' => 'int stack[10];', 'is_correct' => false],
            ['question_id' => 16, 'answer' => 'int* stack = malloc(sizeof(int) * 10);', 'is_correct' => false],
            ['question_id' => 17, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 17, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 18, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 18, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 19, 'answer' => 'Push', 'is_correct' => true],
            ['question_id' => 19, 'answer' => 'Pop', 'is_correct' => true],
            ['question_id' => 19, 'answer' => 'Peek', 'is_correct' => true],
            ['question_id' => 19, 'answer' => 'Sort', 'is_correct' => false],
            ['question_id' => 19, 'answer' => 'IsEmpty', 'is_correct' => true],
            ['question_id' => 20, 'answer' => 'Egyszerű memóriakezelés a verem tetejének nyilvántartásával', 'is_correct' => true],
            ['question_id' => 20, 'answer' => 'Memória állandó méretű marad', 'is_correct' => false],
            ['question_id' => 20, 'answer' => 'Nincs szükség memóriakezelésre', 'is_correct' => false],
            ['question_id' => 21, 'answer' => '1 2 4', 'is_correct' => true],
        ]);


        DB::table('assignments')->insert([
            [
                'sublesson_id' => 4,
                'title' => 'Sorok kezelése programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/data_structures/queues/queues.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 4, 'type' => 'quiz', 'title' => 'Sorok alapjai', 'markdown' => 'Ebben a részben a sorok alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 4, 'type' => 'true_false', 'title' => 'Sorok műveletei', 'markdown' => 'Ebben a részben a sorok különböző műveleteivel kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 4, 'type' => 'checkbox', 'title' => 'Sorok memóriakezelése', 'markdown' => 'Ebben a részben a sorok memóriakezelésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 4, 'type' => 'result', 'title' => 'Memóriakezelési gyakorlat', 'markdown' => Storage::get('markdowns/assignments/data_structures/queues/code_task.md')],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 13, 'markdown' => 'Mi a sor szerepe a programozásban?'],
            ['task_id' => 13, 'markdown' => 'Hogyan hozhatunk létre egy sort?'],
            ['task_id' => 14, 'markdown' => 'A sor elejéről távolítjuk el az elemeket és a végéhez adunk hozzá új elemeket.'],
            ['task_id' => 14, 'markdown' => 'A sorok csak statikus adatszerkezetek lehetnek.'],
            ['task_id' => 15, 'markdown' => 'Mely műveletek tartoznak a sor alapvető műveletei közé?'],
            ['task_id' => 15, 'markdown' => 'Melyik állítás igaz a körkörös sor (circular queue) memóriakezelésére?'],
            ['task_id' => 16, 'markdown' => 'Mi lesz a sor tartalma a fenti műveletek után?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 22, 'answer' => 'Adatok sorozatának FIFO elven történő kezelése', 'is_correct' => true],
            ['question_id' => 22, 'answer' => 'Adatok LIFO elven történő kezelése', 'is_correct' => false],
            ['question_id' => 22, 'answer' => 'Csak számok tárolása', 'is_correct' => false],
            ['question_id' => 23, 'answer' => 'queue<int> q;', 'is_correct' => true],
            ['question_id' => 23, 'answer' => 'int queue[10];', 'is_correct' => false],
            ['question_id' => 23, 'answer' => 'int* queue = malloc(sizeof(int) * 10);', 'is_correct' => false],
            ['question_id' => 24, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 24, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 25, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 25, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 26, 'answer' => 'Enqueue', 'is_correct' => true],
            ['question_id' => 26, 'answer' => 'Dequeue', 'is_correct' => true],
            ['question_id' => 26, 'answer' => 'Peek', 'is_correct' => true],
            ['question_id' => 26, 'answer' => 'Sort', 'is_correct' => false],
            ['question_id' => 26, 'answer' => 'IsEmpty', 'is_correct' => true],
            ['question_id' => 27, 'answer' => 'Hatékonyabb memóriahasználat a memória újrahasználásával', 'is_correct' => true],
            ['question_id' => 27, 'answer' => 'Memória állandó méretű marad', 'is_correct' => false],
            ['question_id' => 27, 'answer' => 'Nincs szükség memóriakezelésre', 'is_correct' => false],
            ['question_id' => 28, 'answer' => 'B C D', 'is_correct' => true],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 5,
                'title' => 'Fák kezelése programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/data_structures/trees/trees.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 5, 'type' => 'quiz', 'title' => 'Fák alapjai', 'markdown' => 'Ebben a részben a fák alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 5, 'type' => 'true_false', 'title' => 'Fák típusai', 'markdown' => 'Ebben a részben a fák különböző típusairól szóló kérdéseket találsz.'],
            ['assignment_id' => 5, 'type' => 'checkbox', 'title' => 'Fa műveletei', 'markdown' => 'Ebben a részben a fa különböző műveleteivel kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 5, 'type' => 'result', 'title' => 'Memóriakezelési gyakorlat', 'markdown' => Storage::get('markdowns/assignments/data_structures/trees/code_task.md')],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 17, 'markdown' => 'Mi a fa szerepe a programozásban?'],
            ['task_id' => 17, 'markdown' => 'Hogyan hozhatunk létre egy bináris fát?'],
            ['task_id' => 18, 'markdown' => 'A bináris fa minden csomópontja legfeljebb két gyermekkel rendelkezhet.'],
            ['task_id' => 18, 'markdown' => 'Az AVL fa kiegyensúlyozott bináris keresőfa.'],
            ['task_id' => 19, 'markdown' => 'Mely műveletek tartoznak a fa alapvető műveletei közé?'],
            ['task_id' => 19, 'markdown' => 'Melyik állítás igaz a fa memóriakezelésére?'],
            ['task_id' => 20, 'markdown' => 'Mi lesz a fa tartalma a fenti műveletek után?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 29, 'answer' => 'Hierarchikus adatszerkezet, amely csomópontokat és gyermekeiket kezeli', 'is_correct' => true],
            ['question_id' => 29, 'answer' => 'Lineáris adatszerkezet, amely sorban tárolja az elemeket', 'is_correct' => false],
            ['question_id' => 29, 'answer' => 'Csak számokat tároló adatszerkezet', 'is_correct' => false],
            ['question_id' => 30, 'answer' => 'struct TreeNode { int data; TreeNode* left; TreeNode* right; };', 'is_correct' => true],
            ['question_id' => 30, 'answer' => 'int tree[10];', 'is_correct' => false],
            ['question_id' => 30, 'answer' => 'TreeNode* tree = malloc(sizeof(TreeNode) * 10);', 'is_correct' => false],
            ['question_id' => 31, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 31, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 32, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 32, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 33, 'answer' => 'Insert', 'is_correct' => true],
            ['question_id' => 33, 'answer' => 'Delete', 'is_correct' => true],
            ['question_id' => 33, 'answer' => 'Search', 'is_correct' => true],
            ['question_id' => 33, 'answer' => 'Traverse', 'is_correct' => true],
            ['question_id' => 33, 'answer' => 'Sort', 'is_correct' => false],
            ['question_id' => 34, 'answer' => 'Dinamikus memóriafoglalás és felszabadítás a csomópontok számára', 'is_correct' => true],
            ['question_id' => 34, 'answer' => 'Állandó méretű memóriafoglalás', 'is_correct' => false],
            ['question_id' => 34, 'answer' => 'Nincs szükség memóriakezelésre', 'is_correct' => false],
            ['question_id' => 35, 'answer' => '1 3 4 6 7 8 13 14', 'is_correct' => true],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 6,
                'title' => 'Grafok kezelése programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/data_structures/graphs/graphs.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 6, 'type' => 'quiz', 'title' => 'Grafok alapjai', 'markdown' => 'Ebben a részben a grafok alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 6, 'type' => 'true_false', 'title' => 'Grafok típusai', 'markdown' => 'Ebben a részben a grafok különböző típusairól szóló kérdéseket találsz.'],
            ['assignment_id' => 6, 'type' => 'checkbox', 'title' => 'Graf reprezentációk', 'markdown' => 'Ebben a részben a graf különböző reprezentációival kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 6, 'type' => 'result', 'title' => 'Memóriakezelési gyakorlat', 'markdown' => Storage::get('markdowns/assignments/data_structures/graphs/code_task.md')],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 21, 'markdown' => 'Mi a graf szerepe a programozásban?'],
            ['task_id' => 21, 'markdown' => 'Hogyan hozhatunk létre egy irányítatlan grafot?'],
            ['task_id' => 22, 'markdown' => 'Az irányítatlan grafban az élek nem rendelkeznek iránnyal.'],
            ['task_id' => 22, 'markdown' => 'A súlyozott grafban az élekhez súlyok vannak rendelve.'],
            ['task_id' => 23, 'markdown' => 'Mely reprezentációk használatosak grafok ábrázolására?'],
            ['task_id' => 23, 'markdown' => 'Melyik állítás igaz a szomszédsági mátrixra?'],
            ['task_id' => 24, 'markdown' => 'Mi lesz a graf tartalma a fenti műveletek után?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 36, 'answer' => 'Csúcsok és élek segítségével modellez különböző kapcsolatokat', 'is_correct' => true],
            ['question_id' => 36, 'answer' => 'Csak sorozatok tárolására használható', 'is_correct' => false],
            ['question_id' => 36, 'answer' => 'Csak fa adatszerkezetek megvalósítására használható', 'is_correct' => false],
            ['question_id' => 37, 'answer' => 'Graph<int> g;', 'is_correct' => true],
            ['question_id' => 37, 'answer' => 'int graph[10];', 'is_correct' => false],
            ['question_id' => 37, 'answer' => 'int* graph = malloc(sizeof(int) * 10);', 'is_correct' => false],
            ['question_id' => 38, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 38, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 39, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 39, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 40, 'answer' => 'Szomszédsági mátrix', 'is_correct' => true],
            ['question_id' => 40, 'answer' => 'Szomszédsági lista', 'is_correct' => true],
            ['question_id' => 40, 'answer' => 'Él lista', 'is_correct' => false],
            ['question_id' => 40, 'answer' => 'Kör lista', 'is_correct' => false],
            ['question_id' => 41, 'answer' => 'Az (i, j) eleme 1, ha van él az i és j csúcs között, különben 0', 'is_correct' => true],
            ['question_id' => 41, 'answer' => 'Az (i, j) eleme a csúcsok távolságát tartalmazza', 'is_correct' => false],
            ['question_id' => 41, 'answer' => 'Az (i, j) eleme a csúcsok közötti legkisebb súlyt tartalmazza', 'is_correct' => false],
            ['question_id' => 42, 'answer' => 'A-B B-C C-D D-A', 'is_correct' => true],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 7,
                'title' => 'Hasító táblák kezelése programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/data_structures/hash_tables/hash_tables.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 7, 'type' => 'quiz', 'title' => 'Hasító táblák alapjai', 'markdown' => 'Ebben a részben a hasító táblák alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 7, 'type' => 'true_false', 'title' => 'Hasító függvények', 'markdown' => 'Ebben a részben a hasító függvényekkel kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 7, 'type' => 'checkbox', 'title' => 'Ütközéskezelési módszerek', 'markdown' => 'Ebben a részben a hasító táblák ütközéskezelési módszereivel kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 25, 'markdown' => 'Mi a hasító tábla szerepe a programozásban?'],
            ['task_id' => 25, 'markdown' => 'Hogyan hozhatunk létre egy hasító táblát?'],
            ['task_id' => 26, 'markdown' => 'A hasító függvény determinisztikus kell, hogy legyen.'],
            ['task_id' => 26, 'markdown' => 'A hasító függvénynek lassúnak kell lennie a nagyobb biztonság érdekében.'],
            ['task_id' => 27, 'markdown' => 'Melyek az ütközéskezelési módszerek közé tartoznak?'],
            ['task_id' => 27, 'markdown' => 'Melyik állítás igaz a láncolás (chaining) módszerre?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 43, 'answer' => 'Kulcs-érték párok hatékony tárolása és keresése', 'is_correct' => true],
            ['question_id' => 43, 'answer' => 'Csak sorozatok tárolására használható', 'is_correct' => false],
            ['question_id' => 43, 'answer' => 'Csak számok tárolására használható', 'is_correct' => false],
            ['question_id' => 44, 'answer' => 'hash_table<int, string> h;', 'is_correct' => true],
            ['question_id' => 44, 'answer' => 'int hash_table[10];', 'is_correct' => false],
            ['question_id' => 44, 'answer' => 'int* hash_table = malloc(sizeof(int) * 10);', 'is_correct' => false],
            ['question_id' => 45, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 45, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 46, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 46, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 47, 'answer' => 'Láncolás (Chaining)', 'is_correct' => true],
            ['question_id' => 47, 'answer' => 'Nyílt címzés (Open Addressing)', 'is_correct' => true],
            ['question_id' => 47, 'answer' => 'Linearizáció', 'is_correct' => false],
            ['question_id' => 47, 'answer' => 'Parcellázás', 'is_correct' => false],
            ['question_id' => 48, 'answer' => 'Minden hasító értékhez egy láncolt lista tartozik', 'is_correct' => true],
            ['question_id' => 48, 'answer' => 'A hasító táblán belül új helyre helyezzük az ütközött elemeket', 'is_correct' => false],
            ['question_id' => 48, 'answer' => 'Minden kulcsot azonos indexre mappel', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 8,
                'title' => 'Beszúró rendezés programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/sorting_algorithms/insertion_sort/insertion_sort.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 8, 'type' => 'quiz', 'title' => 'Beszúró rendezés alapjai', 'markdown' => 'Ebben a részben a beszúró rendezés alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 8, 'type' => 'true_false', 'title' => 'Beszúró rendezés működése', 'markdown' => 'Ebben a részben a beszúró rendezés működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 8, 'type' => 'checkbox', 'title' => 'Beszúró rendezés komplexitása', 'markdown' => 'Ebben a részben a beszúró rendezés idő- és térbeli komplexitásával kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 28, 'markdown' => 'Mi a beszúró rendezés szerepe a programozásban?'],
            ['task_id' => 28, 'markdown' => 'Hogyan működik a beszúró rendezés?'],
            ['task_id' => 29, 'markdown' => 'A beszúró rendezés az adatsort két részre osztja: a rendezett és a rendezetlen részre.'],
            ['task_id' => 29, 'markdown' => 'A beszúró rendezés időbeli komplexitása a legrosszabb esetben O(n).'],
            ['task_id' => 30, 'markdown' => 'Melyek a beszúró rendezés időbeli komplexitásai különböző esetekben?'],
            ['task_id' => 30, 'markdown' => 'Melyik állítás igaz a beszúró rendezés térbeli komplexitására?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 50, 'answer' => 'Kis méretű vagy részben rendezett adatsorok hatékony rendezése', 'is_correct' => true],
            ['question_id' => 50, 'answer' => 'Nagy méretű adatsorok hatékony rendezése', 'is_correct' => false],
            ['question_id' => 50, 'answer' => 'Csak szöveges adatok rendezése', 'is_correct' => false],
            ['question_id' => 51, 'answer' => 'Az algoritmus iterál a rendezetlen részen, és minden egyes elemét beilleszti a megfelelő helyre a rendezett részben.', 'is_correct' => true],
            ['question_id' => 51, 'answer' => 'Az algoritmus minden elemet egy új listába másol.', 'is_correct' => false],
            ['question_id' => 51, 'answer' => 'Az algoritmus két részre osztja az adatsort, és párhuzamosan rendezi őket.', 'is_correct' => false],
            ['question_id' => 52, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 52, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 53, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 53, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 54, 'answer' => 'O(n^2) a legrosszabb esetben', 'is_correct' => true],
            ['question_id' => 54, 'answer' => 'O(n) a legjobb esetben', 'is_correct' => true],
            ['question_id' => 54, 'answer' => 'O(log n) az átlagos esetben', 'is_correct' => false],
            ['question_id' => 54, 'answer' => 'O(1) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 55, 'answer' => 'O(1), mert csak egy kis mennyiségű extra memóriát használ', 'is_correct' => true],
            ['question_id' => 55, 'answer' => 'O(n), mert az összes elemet újra kell rendezni', 'is_correct' => false],
            ['question_id' => 55, 'answer' => 'O(log n), mert az algoritmus bináris keresést használ', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 9,
                'title' => 'Kiválasztásos rendezés programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/sorting_algorithms/selection_sort/selection_sort.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 9, 'type' => 'quiz', 'title' => 'Kiválasztásos rendezés alapjai', 'markdown' => 'Ebben a részben a kiválasztásos rendezés alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 9, 'type' => 'true_false', 'title' => 'Kiválasztásos rendezés működése', 'markdown' => 'Ebben a részben a kiválasztásos rendezés működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 9, 'type' => 'checkbox', 'title' => 'Kiválasztásos rendezés komplexitása', 'markdown' => 'Ebben a részben a kiválasztásos rendezés idő- és térbeli komplexitásával kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 31, 'markdown' => 'Mi a kiválasztásos rendezés szerepe a programozásban?'],
            ['task_id' => 31, 'markdown' => 'Hogyan működik a kiválasztásos rendezés?'],
            ['task_id' => 32, 'markdown' => 'A kiválasztásos rendezés az adatsort két részre osztja: a rendezett és a rendezetlen részre.'],
            ['task_id' => 32, 'markdown' => 'A kiválasztásos rendezés időbeli komplexitása a legrosszabb esetben O(n).'],
            ['task_id' => 33, 'markdown' => 'Melyek a kiválasztásos rendezés időbeli komplexitásai különböző esetekben?'],
            ['task_id' => 33, 'markdown' => 'Melyik állítás igaz a kiválasztásos rendezés térbeli komplexitására?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 57, 'answer' => 'Kis méretű adatsorok hatékony rendezése', 'is_correct' => true],
            ['question_id' => 57, 'answer' => 'Nagy méretű adatsorok hatékony rendezése', 'is_correct' => false],
            ['question_id' => 57, 'answer' => 'Csak szöveges adatok rendezése', 'is_correct' => false],
            ['question_id' => 58, 'answer' => 'Az algoritmus iterál a rendezetlen részen, kiválasztja a legkisebb elemet, és kicseréli azt a rendezetlen rész első elemével.', 'is_correct' => true],
            ['question_id' => 58, 'answer' => 'Az algoritmus minden elemet egy új listába másol.', 'is_correct' => false],
            ['question_id' => 58, 'answer' => 'Az algoritmus két részre osztja az adatsort, és párhuzamosan rendezi őket.', 'is_correct' => false],
            ['question_id' => 59, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 59, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 60, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 60, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 61, 'answer' => 'O(n^2) a legrosszabb esetben', 'is_correct' => true],
            ['question_id' => 61, 'answer' => 'O(n) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 61, 'answer' => 'O(n^2) az átlagos esetben', 'is_correct' => true],
            ['question_id' => 61, 'answer' => 'O(1) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 62, 'answer' => 'O(1), mert csak egy kis mennyiségű extra memóriát használ', 'is_correct' => true],
            ['question_id' => 62, 'answer' => 'O(n), mert az összes elemet újra kell rendezni', 'is_correct' => false],
            ['question_id' => 62, 'answer' => 'O(log n), mert az algoritmus bináris keresést használ', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 10,
                'title' => 'Összefésüléses rendezés programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/sorting_algorithms/merge_sort/merge_sort.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 10, 'type' => 'quiz', 'title' => 'Összefésüléses rendezés alapjai', 'markdown' => 'Ebben a részben az összefésüléses rendezés alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 10, 'type' => 'true_false', 'title' => 'Összefésüléses rendezés működése', 'markdown' => 'Ebben a részben az összefésüléses rendezés működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 10, 'type' => 'checkbox', 'title' => 'Összefésüléses rendezés komplexitása', 'markdown' => 'Ebben a részben az összefésüléses rendezés idő- és térbeli komplexitásával kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 34, 'markdown' => 'Mi az összefésüléses rendezés szerepe a programozásban?'],
            ['task_id' => 34, 'markdown' => 'Hogyan működik az összefésüléses rendezés?'],
            ['task_id' => 35, 'markdown' => 'Az összefésüléses rendezés stabil rendezési algoritmus.'],
            ['task_id' => 35, 'markdown' => 'Az összefésüléses rendezés időbeli komplexitása a legrosszabb esetben O(n log n).'],
            ['task_id' => 36, 'markdown' => 'Melyek az összefésüléses rendezés időbeli komplexitásai különböző esetekben?'],
            ['task_id' => 36, 'markdown' => 'Melyik állítás igaz az összefésüléses rendezés térbeli komplexitására?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 64, 'answer' => 'Nagy méretű adatsorok hatékony rendezése', 'is_correct' => true],
            ['question_id' => 64, 'answer' => 'Kis méretű adatsorok hatékony rendezése', 'is_correct' => false],
            ['question_id' => 64, 'answer' => 'Csak szöveges adatok rendezése', 'is_correct' => false],
            ['question_id' => 65, 'answer' => 'Az algoritmus az adatsort két részre bontja, majd azokat rendezi és összefésüli.', 'is_correct' => true],
            ['question_id' => 65, 'answer' => 'Az algoritmus minden elemet egy új listába másol.', 'is_correct' => false],
            ['question_id' => 65, 'answer' => 'Az algoritmus két részre osztja az adatsort, és párhuzamosan rendezi őket.', 'is_correct' => false],
            ['question_id' => 66, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 66, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 67, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 67, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 68, 'answer' => 'O(n log n) a legrosszabb esetben', 'is_correct' => true],
            ['question_id' => 68, 'answer' => 'O(n) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 68, 'answer' => 'O(n log n) az átlagos esetben', 'is_correct' => true],
            ['question_id' => 68, 'answer' => 'O(1) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 69, 'answer' => 'O(n), mert szükség van kiegészítő memóriára az összefésülés során', 'is_correct' => true],
            ['question_id' => 69, 'answer' => 'O(1), mert az összefésülés nem igényel extra memóriát', 'is_correct' => false],
            ['question_id' => 69, 'answer' => 'O(n^2), mert az összefésülés hosszú időt vesz igénybe', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 11,
                'title' => 'Gyorsrendezés programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/sorting_algorithms/quick_sort/quick_sort.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 11, 'type' => 'quiz', 'title' => 'Gyorsrendezés alapjai', 'markdown' => 'Ebben a részben a gyorsrendezés alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 11, 'type' => 'true_false', 'title' => 'Gyorsrendezés működése', 'markdown' => 'Ebben a részben a gyorsrendezés működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 11, 'type' => 'checkbox', 'title' => 'Gyorsrendezés komplexitása', 'markdown' => 'Ebben a részben a gyorsrendezés idő- és térbeli komplexitásával kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 37, 'markdown' => 'Mi a gyorsrendezés szerepe a programozásban?'],
            ['task_id' => 37, 'markdown' => 'Hogyan működik a gyorsrendezés?'],
            ['task_id' => 38, 'markdown' => 'A gyorsrendezés in-place rendezési algoritmus.'],
            ['task_id' => 38, 'markdown' => 'A gyorsrendezés időbeli komplexitása a legrosszabb esetben O(n log n).'],
            ['task_id' => 39, 'markdown' => 'Melyek a gyorsrendezés időbeli komplexitásai különböző esetekben?'],
            ['task_id' => 39, 'markdown' => 'Melyik állítás igaz a gyorsrendezés térbeli komplexitására?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 71, 'answer' => 'Nagy méretű adatsorok hatékony rendezése', 'is_correct' => true],
            ['question_id' => 71, 'answer' => 'Kis méretű adatsorok hatékony rendezése', 'is_correct' => false],
            ['question_id' => 71, 'answer' => 'Csak szöveges adatok rendezése', 'is_correct' => false],
            ['question_id' => 72, 'answer' => 'Az algoritmus az adatsort két részre bontja, és a pivot elem alapján rendezi.', 'is_correct' => true],
            ['question_id' => 72, 'answer' => 'Az algoritmus minden elemet egy új listába másol.', 'is_correct' => false],
            ['question_id' => 72, 'answer' => 'Az algoritmus két részre osztja az adatsort, és párhuzamosan rendezi őket.', 'is_correct' => false],
            ['question_id' => 73, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 73, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 74, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 74, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 75, 'answer' => 'O(n log n) a legrosszabb esetben', 'is_correct' => false],
            ['question_id' => 75, 'answer' => 'O(n) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 75, 'answer' => 'O(n log n) az átlagos esetben', 'is_correct' => true],
            ['question_id' => 75, 'answer' => 'O(1) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 76, 'answer' => 'O(log n), mert szükség van kiegészítő memóriára a rekurzív hívásokhoz', 'is_correct' => true],
            ['question_id' => 76, 'answer' => 'O(1), mert az algoritmus nem igényel extra memóriát', 'is_correct' => false],
            ['question_id' => 76, 'answer' => 'O(n^2), mert az összefésülés hosszú időt vesz igénybe', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 12,
                'title' => 'Kupacrendezés programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/sorting_algorithms/heap_sort/heap_sort.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 12, 'type' => 'quiz', 'title' => 'Kupacrendezés alapjai', 'markdown' => 'Ebben a részben a kupacrendezés alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 12, 'type' => 'true_false', 'title' => 'Kupacrendezés működése', 'markdown' => 'Ebben a részben a kupacrendezés működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 12, 'type' => 'checkbox', 'title' => 'Kupacrendezés komplexitása', 'markdown' => 'Ebben a részben a kupacrendezés idő- és térbeli komplexitásával kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 40, 'markdown' => 'Mi a kupacrendezés szerepe a programozásban?'],
            ['task_id' => 40, 'markdown' => 'Hogyan működik a kupacrendezés?'],
            ['task_id' => 41, 'markdown' => 'A kupacrendezés egy stabil rendezési algoritmus.'],
            ['task_id' => 41, 'markdown' => 'A kupacrendezés időbeli komplexitása a legrosszabb esetben O(n log n).'],
            ['task_id' => 42, 'markdown' => 'Melyek a kupacrendezés időbeli komplexitásai különböző esetekben?'],
            ['task_id' => 42, 'markdown' => 'Melyik állítás igaz a kupacrendezés térbeli komplexitására?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 78, 'answer' => 'Nagy méretű adatsorok hatékony rendezése', 'is_correct' => true],
            ['question_id' => 78, 'answer' => 'Kis méretű adatsorok hatékony rendezése', 'is_correct' => false],
            ['question_id' => 78, 'answer' => 'Csak szöveges adatok rendezése', 'is_correct' => false],
            ['question_id' => 79, 'answer' => 'Az algoritmus az adatsort kupaccá alakítja, majd rendezi.', 'is_correct' => true],
            ['question_id' => 79, 'answer' => 'Az algoritmus minden elemet egy új listába másol.', 'is_correct' => false],
            ['question_id' => 79, 'answer' => 'Az algoritmus két részre osztja az adatsort, és párhuzamosan rendezi őket.', 'is_correct' => false],
            ['question_id' => 80, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 80, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 81, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 81, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 82, 'answer' => 'O(n log n) a legrosszabb esetben', 'is_correct' => true],
            ['question_id' => 82, 'answer' => 'O(n) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 82, 'answer' => 'O(n log n) az átlagos esetben', 'is_correct' => true],
            ['question_id' => 82, 'answer' => 'O(1) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 83, 'answer' => 'O(1), mert in-place algoritmus', 'is_correct' => true],
            ['question_id' => 83, 'answer' => 'O(n), mert szükség van kiegészítő memóriára', 'is_correct' => false],
            ['question_id' => 83, 'answer' => 'O(n^2), mert az algoritmus sok időt vesz igénybe', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 13,
                'title' => 'Edényrendezés (Bucket Sort) programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/sorting_algorithms/bucket_sort/bucket_sort.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 13, 'type' => 'quiz', 'title' => 'Edényrendezés alapjai', 'markdown' => 'Ebben a részben az edényrendezés alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 13, 'type' => 'true_false', 'title' => 'Edényrendezés működése', 'markdown' => 'Ebben a részben az edényrendezés működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 13, 'type' => 'checkbox', 'title' => 'Edényrendezés komplexitása', 'markdown' => 'Ebben a részben az edényrendezés idő- és térbeli komplexitásával kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 43, 'markdown' => 'Mi az edényrendezés szerepe a programozásban?'],
            ['task_id' => 43, 'markdown' => 'Hogyan működik az edényrendezés?'],
            ['task_id' => 44, 'markdown' => 'Az edényrendezés stabil rendezési algoritmus.'],
            ['task_id' => 44, 'markdown' => 'Az edényrendezés időbeli komplexitása átlagosan O(n + k).'],
            ['task_id' => 45, 'markdown' => 'Melyek az edényrendezés időbeli komplexitásai különböző esetekben?'],
            ['task_id' => 45, 'markdown' => 'Melyik állítás igaz az edényrendezés térbeli komplexitására?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 85, 'answer' => 'Nagy méretű adatsorok hatékony rendezése ismert tartományban', 'is_correct' => true],
            ['question_id' => 85, 'answer' => 'Kis méretű adatsorok hatékony rendezése', 'is_correct' => false],
            ['question_id' => 85, 'answer' => 'Csak szöveges adatok rendezése', 'is_correct' => false],
            ['question_id' => 86, 'answer' => 'Az algoritmus az adatsort edényekre bontja, majd azokat rendezi és összeilleszti.', 'is_correct' => true],
            ['question_id' => 86, 'answer' => 'Az algoritmus minden elemet egy új listába másol.', 'is_correct' => false],
            ['question_id' => 86, 'answer' => 'Az algoritmus két részre osztja az adatsort, és párhuzamosan rendezi őket.', 'is_correct' => false],
            ['question_id' => 87, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 87, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 88, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 88, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 89, 'answer' => 'O(n + k), ahol n az elemek száma és k az edények száma', 'is_correct' => true],
            ['question_id' => 89, 'answer' => 'O(n log n) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 89, 'answer' => 'O(n^2) az átlagos esetben', 'is_correct' => false],
            ['question_id' => 89, 'answer' => 'O(1) a legrosszabb esetben', 'is_correct' => false],
            ['question_id' => 90, 'answer' => 'O(n + k), mivel extra memóriát igényel az edények és az átmeneti tárolás számára', 'is_correct' => true],
            ['question_id' => 90, 'answer' => 'O(1), mert in-place algoritmus', 'is_correct' => false],
            ['question_id' => 90, 'answer' => 'O(n^2), mert az algoritmus sok időt vesz igénybe', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 14,
                'title' => 'Leszámláló rendezés (Counting Sort) programozásban - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/sorting_algorithms/counting_sort/counting_sort.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 14, 'type' => 'quiz', 'title' => 'Leszámláló rendezés alapjai', 'markdown' => 'Ebben a részben a leszámláló rendezés alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 14, 'type' => 'true_false', 'title' => 'Leszámláló rendezés működése', 'markdown' => 'Ebben a részben a leszámláló rendezés működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 14, 'type' => 'checkbox', 'title' => 'Leszámláló rendezés komplexitása', 'markdown' => 'Ebben a részben a leszámláló rendezés idő- és térbeli komplexitásával kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 46, 'markdown' => 'Mi a leszámláló rendezés szerepe a programozásban?'],
            ['task_id' => 46, 'markdown' => 'Hogyan működik a leszámláló rendezés?'],
            ['task_id' => 47, 'markdown' => 'A leszámláló rendezés stabil rendezési algoritmus.'],
            ['task_id' => 47, 'markdown' => 'A leszámláló rendezés időbeli komplexitása átlagosan O(n + k).'],
            ['task_id' => 48, 'markdown' => 'Melyek a leszámláló rendezés időbeli komplexitásai különböző esetekben?'],
            ['task_id' => 48, 'markdown' => 'Melyik állítás igaz a leszámláló rendezés térbeli komplexitására?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 92, 'answer' => 'Nagy méretű adatsorok hatékony rendezése ismert tartományban', 'is_correct' => true],
            ['question_id' => 92, 'answer' => 'Kis méretű adatsorok hatékony rendezése', 'is_correct' => false],
            ['question_id' => 92, 'answer' => 'Csak szöveges adatok rendezése', 'is_correct' => false],
            ['question_id' => 93, 'answer' => 'Az algoritmus az adatsort számláló tömbre bontja, majd azokat rendezi és összeilleszti.', 'is_correct' => true],
            ['question_id' => 93, 'answer' => 'Az algoritmus minden elemet egy új listába másol.', 'is_correct' => false],
            ['question_id' => 93, 'answer' => 'Az algoritmus két részre osztja az adatsort, és párhuzamosan rendezi őket.', 'is_correct' => false],
            ['question_id' => 94, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 94, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 95, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 95, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 96, 'answer' => 'O(n + k), ahol n az elemek száma és k a legnagyobb érték az adatsorban', 'is_correct' => true],
            ['question_id' => 96, 'answer' => 'O(n log n) a legjobb esetben', 'is_correct' => false],
            ['question_id' => 96, 'answer' => 'O(n^2) az átlagos esetben', 'is_correct' => false],
            ['question_id' => 96, 'answer' => 'O(1) a legrosszabb esetben', 'is_correct' => false],
            ['question_id' => 97, 'answer' => 'O(n + k), mivel extra memóriát igényel a számláló és a kimeneti tömbök számára', 'is_correct' => true],
            ['question_id' => 97, 'answer' => 'O(1), mert in-place algoritmus', 'is_correct' => false],
            ['question_id' => 97, 'answer' => 'O(n^2), mert az algoritmus sok időt vesz igénybe', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 15,
                'title' => 'Radix rendezés - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/sorting_algorithms/radix_sort/radix_sort.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 15, 'type' => 'quiz', 'title' => 'Radix rendezés alapjai', 'markdown' => 'Ebben a részben a radix rendezés alapvető működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 15, 'type' => 'true_false', 'title' => 'Radix rendezés elmélete', 'markdown' => 'Ebben a részben a radix rendezés elméleti alapjaival kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 15, 'type' => 'checkbox', 'title' => 'Radix rendezés gyakorlati alkalmazásai', 'markdown' => 'Ebben a részben a radix rendezés gyakorlati alkalmazásaival kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 49, 'markdown' => 'Mi a radix rendezés lényege?'],
            ['task_id' => 49, 'markdown' => 'Melyik rendezési algoritmus használható a radix rendezés során a stabilitás biztosítására?'],
            ['task_id' => 50, 'markdown' => 'A radix rendezés időbeli komplexitása O(d*(n+k)), ahol n az elemek száma, k a helyiértékek száma, d pedig az adott helyiérték maximális értéke.'],
            ['task_id' => 50, 'markdown' => 'A radix rendezés nem igényel kiegészítő memóriát.'],
            ['task_id' => 51, 'markdown' => 'Mely állítások igazak a radix rendezésre?'],
            ['task_id' => 51, 'markdown' => 'Milyen típusú adatok rendezésére alkalmas a radix rendezés?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 99, 'answer' => 'Adatok csoportos tárolása', 'is_correct' => false],
            ['question_id' => 99, 'answer' => 'Adatok komparatív rendezése', 'is_correct' => false],
            ['question_id' => 99, 'answer' => 'Adatok nem-komparatív rendezése', 'is_correct' => true],
            ['question_id' => 100, 'answer' => 'Quicksort', 'is_correct' => false],
            ['question_id' => 100, 'answer' => 'Mergesort', 'is_correct' => false],
            ['question_id' => 100, 'answer' => 'Countingsort', 'is_correct' => true],
            ['question_id' => 101, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 101, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 102, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 102, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 103, 'answer' => 'Különösen hatékony fix hosszúságú adatok rendezésére.', 'is_correct' => true],
            ['question_id' => 103, 'answer' => 'Jól skálázható nagy adatsorok esetén.', 'is_correct' => true],
            ['question_id' => 103, 'answer' => 'Mindig gyorsabb, mint a quicksort.', 'is_correct' => false],
            ['question_id' => 103, 'answer' => 'Komparatív rendezési algoritmus.', 'is_correct' => false],
            ['question_id' => 104, 'answer' => 'Számok', 'is_correct' => true],
            ['question_id' => 104, 'answer' => 'Szavak', 'is_correct' => true],
            ['question_id' => 104, 'answer' => 'Bonyolult adatstruktúrák', 'is_correct' => false],
            ['question_id' => 104, 'answer' => 'Lebegőpontos számok', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 16,
                'title' => 'Gráfok reprezentációja - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/graph_algorithms/graph_representations/graph_representations.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 16, 'type' => 'quiz', 'title' => 'Szomszédsági mátrix', 'markdown' => 'Ebben a részben a gráfok szomszédsági mátrixszal való reprezentálásával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 16, 'type' => 'true_false', 'title' => 'Szomszédsági lista', 'markdown' => 'Ebben a részben a gráfok szomszédsági listával való reprezentálásával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 16, 'type' => 'checkbox', 'title' => 'Él lista', 'markdown' => 'Ebben a részben a gráfok él listával való reprezentálásával kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 52, 'markdown' => 'Mi a szomszédsági mátrix előnye egy gráf reprezentációjában?'],
            ['task_id' => 52, 'markdown' => 'Milyen esetben nem érdemes szomszédsági mátrixot használni?'],
            ['task_id' => 53, 'markdown' => 'A szomszédsági lista kevesebb memóriát használ, mint a szomszédsági mátrix.'],
            ['task_id' => 53, 'markdown' => 'A szomszédsági lista reprezentációja gyorsabb keresést tesz lehetővé, mint a szomszédsági mátrix.'],
            ['task_id' => 54, 'markdown' => 'Melyik állítás igaz az él listára?'],
            ['task_id' => 54, 'markdown' => 'Melyik állítás hamis az él listára vonatkozóan?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 106, 'answer' => 'Gyors keresést tesz lehetővé', 'is_correct' => true],
            ['question_id' => 106, 'answer' => 'Kevesebb memóriát használ', 'is_correct' => false],
            ['question_id' => 106, 'answer' => 'Egyszerű implementálni', 'is_correct' => false],
            ['question_id' => 107, 'answer' => 'Ha a gráf ritka', 'is_correct' => true],
            ['question_id' => 107, 'answer' => 'Ha a gráf sűrű', 'is_correct' => false],
            ['question_id' => 107, 'answer' => 'Ha gyors keresésre van szükség', 'is_correct' => false],
            ['question_id' => 108, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 108, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 109, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 109, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 110, 'answer' => 'Az él lista hatékonyan tárolja a ritka gráfokat', 'is_correct' => true],
            ['question_id' => 110, 'answer' => 'Az él lista könnyen skálázható', 'is_correct' => true],
            ['question_id' => 110, 'answer' => 'Az él lista gyors keresést biztosít', 'is_correct' => false],
            ['question_id' => 110, 'answer' => 'Az él lista kevesebb memóriát használ, mint a szomszédsági mátrix', 'is_correct' => true],
            ['question_id' => 111, 'answer' => 'Az él lista tárolása gyorsabb, mint a szomszédsági mátrix', 'is_correct' => false],
            ['question_id' => 111, 'answer' => 'Az él lista hatékonyan tárolja a sűrű gráfokat', 'is_correct' => false],
            ['question_id' => 111, 'answer' => 'Az él lista kevesebb memóriát használ ritka gráfok esetén', 'is_correct' => true],
            ['question_id' => 111, 'answer' => 'Az él lista könnyen implementálható', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 17,
                'title' => 'Szélességi keresés - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/graph_algorithms/breadth_first_search/breadth_first_search.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 17, 'type' => 'quiz', 'title' => 'BFS alapjai', 'markdown' => 'Ebben a részben a szélességi keresés alapvető működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 17, 'type' => 'true_false', 'title' => 'BFS előnyei és hátrányai', 'markdown' => 'Ebben a részben a szélességi keresés előnyeivel és hátrányaival kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 17, 'type' => 'checkbox', 'title' => 'BFS alkalmazása', 'markdown' => 'Ebben a részben a szélességi keresés különböző alkalmazásaival kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 55, 'markdown' => 'Mi a szélességi keresés alapelve?'],
            ['task_id' => 55, 'markdown' => 'Milyen adatszerkezetet használ a BFS?'],
            ['task_id' => 56, 'markdown' => 'A BFS mindig megtalálja a legrövidebb utat az induló csomóponttól a célcsomópontig, ha a gráfban minden él azonos súlyú.'],
            ['task_id' => 56, 'markdown' => 'A BFS hatékonyan alkalmazható mind súlyozott, mind súlyozatlan gráfokon.'],
            ['task_id' => 57, 'markdown' => 'Melyik feladatban alkalmazható hatékonyan a BFS?'],
            ['task_id' => 57, 'markdown' => 'Melyik állítás igaz a BFS-re vonatkozóan?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 113, 'answer' => 'Szintenként halad végig a gráfon', 'is_correct' => true],
            ['question_id' => 113, 'answer' => 'Mélységi irányban halad végig a gráfon', 'is_correct' => false],
            ['question_id' => 113, 'answer' => 'Véletlenszerűen halad végig a gráfon', 'is_correct' => false],
            ['question_id' => 114, 'answer' => 'Verem', 'is_correct' => false],
            ['question_id' => 114, 'answer' => 'Sor', 'is_correct' => true],
            ['question_id' => 114, 'answer' => 'Lista', 'is_correct' => false],
            ['question_id' => 115, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 115, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 116, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 116, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 117, 'answer' => 'Legkisebb költségű út megtalálása súlyozatlan gráfban', 'is_correct' => true],
            ['question_id' => 117, 'answer' => 'Legnagyobb költségű út megtalálása súlyozott gráfban', 'is_correct' => false],
            ['question_id' => 117, 'answer' => 'Gráf összefüggőség vizsgálata', 'is_correct' => true],
            ['question_id' => 117, 'answer' => 'Gráf körmentességének ellenőrzése', 'is_correct' => true],
            ['question_id' => 118, 'answer' => 'A BFS mindig megtalálja a legrövidebb utat bármilyen gráfban', 'is_correct' => false],
            ['question_id' => 118, 'answer' => 'A BFS csak súlyozatlan gráfokban garantáltan találja meg a legrövidebb utat', 'is_correct' => true],
            ['question_id' => 118, 'answer' => 'A BFS minden esetben kevesebb memóriát használ, mint a DFS', 'is_correct' => false],
            ['question_id' => 118, 'answer' => 'A BFS működése nem függ a gráf struktúrájától', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 18,
                'title' => 'Mélységi keresés - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/graph_algorithms/depth_first_search/depth_first_search.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 18, 'type' => 'quiz', 'title' => 'DFS alapjai', 'markdown' => 'Ebben a részben a mélységi keresés alapvető működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 18, 'type' => 'true_false', 'title' => 'DFS előnyei és hátrányai', 'markdown' => 'Ebben a részben a mélységi keresés előnyeivel és hátrányaival kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 18, 'type' => 'checkbox', 'title' => 'DFS alkalmazása', 'markdown' => 'Ebben a részben a mélységi keresés különböző alkalmazásaival kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 58, 'markdown' => 'Mi a mélységi keresés alapelve?'],
            ['task_id' => 58, 'markdown' => 'Milyen adatszerkezetet használ a DFS?'],
            ['task_id' => 59, 'markdown' => 'A DFS mindig megtalálja a legrövidebb utat az induló csomóponttól a célcsomópontig.'],
            ['task_id' => 59, 'markdown' => 'A DFS hatékonyan alkalmazható mind súlyozott, mind súlyozatlan gráfokon.'],
            ['task_id' => 60, 'markdown' => 'Melyik feladatban alkalmazható hatékonyan a DFS?'],
            ['task_id' => 60, 'markdown' => 'Melyik állítás igaz a DFS-re vonatkozóan?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 120, 'answer' => 'Mélységi irányban halad végig a gráfon', 'is_correct' => true],
            ['question_id' => 120, 'answer' => 'Szintenként halad végig a gráfon', 'is_correct' => false],
            ['question_id' => 120, 'answer' => 'Véletlenszerűen halad végig a gráfon', 'is_correct' => false],
            ['question_id' => 121, 'answer' => 'Verem', 'is_correct' => true],
            ['question_id' => 121, 'answer' => 'Sor', 'is_correct' => false],
            ['question_id' => 121, 'answer' => 'Lista', 'is_correct' => false],
            ['question_id' => 122, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 122, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 123, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 123, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 124, 'answer' => 'Gráf körmentességének ellenőrzése', 'is_correct' => true],
            ['question_id' => 124, 'answer' => 'Legkisebb költségű út megtalálása súlyozatlan gráfban', 'is_correct' => false],
            ['question_id' => 124, 'answer' => 'Gráf összefüggőség vizsgálata', 'is_correct' => true],
            ['question_id' => 124, 'answer' => 'Gráf minimális feszítőfájának megtalálása', 'is_correct' => false],
            ['question_id' => 125, 'answer' => 'A DFS mindig megtalálja a legrövidebb utat bármilyen gráfban', 'is_correct' => false],
            ['question_id' => 125, 'answer' => 'A DFS általában mélyebbre hatol a gráfban, mielőtt visszalépne', 'is_correct' => true],
            ['question_id' => 125, 'answer' => 'A DFS mindig kevesebb memóriát használ, mint a BFS', 'is_correct' => false],
            ['question_id' => 125, 'answer' => 'A DFS működése nem függ a gráf struktúrájától', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 19,
                'title' => 'Legrövidebb út algoritmusok - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/graph_algorithms/shortest_path_algorithms/shortest_path_algorithms.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 19, 'type' => 'quiz', 'title' => 'Legrövidebb út algoritmusok alapjai', 'markdown' => 'Ebben a részben a legrövidebb út algoritmusok alapvető működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 19, 'type' => 'true_false', 'title' => 'Dijkstra algoritmus', 'markdown' => 'Ebben a részben a Dijkstra algoritmus működésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 19, 'type' => 'checkbox', 'title' => 'Bellman-Ford algoritmus', 'markdown' => 'Ebben a részben a Bellman-Ford algoritmus működésével és alkalmazásával kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 61, 'markdown' => 'Mi a legrövidebb út algoritmusok célja?'],
            ['task_id' => 61, 'markdown' => 'Milyen típusú gráfok esetén használhatóak a legrövidebb út algoritmusok?'],
            ['task_id' => 62, 'markdown' => 'A Dijkstra algoritmus csak nem negatív súlyú élek esetén működik.'],
            ['task_id' => 62, 'markdown' => 'A Dijkstra algoritmus használható mind irányított, mind irányítatlan gráfok esetén.'],
            ['task_id' => 63, 'markdown' => 'Melyik állítás igaz a Bellman-Ford algoritmusra?'],
            ['task_id' => 63, 'markdown' => 'Melyik feladatban alkalmazható hatékonyan a Bellman-Ford algoritmus?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 127, 'answer' => 'A legkisebb súlyú út megtalálása két csomópont között', 'is_correct' => true],
            ['question_id' => 127, 'answer' => 'A legnagyobb súlyú út megtalálása két csomópont között', 'is_correct' => false],
            ['question_id' => 127, 'answer' => 'A legrövidebb ciklus megtalálása a gráfban', 'is_correct' => false],
            ['question_id' => 128, 'answer' => 'Súlyozott gráfok', 'is_correct' => true],
            ['question_id' => 128, 'answer' => 'Súlyozatlan gráfok', 'is_correct' => true],
            ['question_id' => 128, 'answer' => 'Csak irányított gráfok', 'is_correct' => false],
            ['question_id' => 128, 'answer' => 'Csak irányítatlan gráfok', 'is_correct' => false],
            ['question_id' => 129, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 129, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 130, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 130, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 131, 'answer' => 'Minden lehetséges út megvizsgálása', 'is_correct' => true],
            ['question_id' => 131, 'answer' => 'Csak a legrövidebb út megvizsgálása', 'is_correct' => false],
            ['question_id' => 131, 'answer' => 'Csak pozitív súlyú élek kezelése', 'is_correct' => false],
            ['question_id' => 131, 'answer' => 'Negatív súlyú élek kezelése', 'is_correct' => true],
            ['question_id' => 132, 'answer' => 'A Bellman-Ford algoritmus minden típusú gráfban alkalmazható', 'is_correct' => true],
            ['question_id' => 132, 'answer' => 'A Bellman-Ford algoritmus csak súlyozatlan gráfokban működik', 'is_correct' => false],
            ['question_id' => 132, 'answer' => 'A Bellman-Ford algoritmus mindig hatékonyabb, mint a Dijkstra algoritmus', 'is_correct' => false],
            ['question_id' => 132, 'answer' => 'A Bellman-Ford algoritmus nem működik negatív súlyú élekkel', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 20,
                'title' => 'Pointerek használata C++ nyelven - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/c/pointers/pointers.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 20, 'type' => 'quiz', 'title' => 'Pointerek alapjai', 'markdown' => 'Ebben a részben a pointerek alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 20, 'type' => 'true_false', 'title' => 'Pointerek és címképzés', 'markdown' => 'Ebben a részben a pointerek címképzésével kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 20, 'type' => 'checkbox', 'title' => 'Dinamikus memória kezelés', 'markdown' => 'Ebben a részben a dinamikus memória kezeléssel kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 64, 'markdown' => 'Mi a pointerek szerepe a programozásban?'],
            ['task_id' => 64, 'markdown' => 'Hogyan deklarálunk és inicializálunk egy `int` típusú pointert C++ nyelven?'],
            ['task_id' => 65, 'markdown' => 'A pointerek mindig tartalmaznak érvényes memóriacímet.'],
            ['task_id' => 65, 'markdown' => 'A `*` operátorral hozzáférhetünk a pointer által hivatkozott memória területén tárolt értékhez.'],
            ['task_id' => 66, 'markdown' => 'Melyik operátorokat használjuk a dinamikus memória foglalására és felszabadítására C++ nyelven?'],
            ['task_id' => 66, 'markdown' => 'Melyik állítás igaz a pointer aritmetikára?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 134, 'answer' => 'Adatok memóriacímének tárolása és kezelése', 'is_correct' => true],
            ['question_id' => 134, 'answer' => 'Változók értékeinek tárolása', 'is_correct' => false],
            ['question_id' => 134, 'answer' => 'Adatok rendezése', 'is_correct' => false],
            ['question_id' => 135, 'answer' => 'int* ptr = &val;', 'is_correct' => true],
            ['question_id' => 135, 'answer' => 'int ptr = &val;', 'is_correct' => false],
            ['question_id' => 135, 'answer' => 'int ptr = val;', 'is_correct' => false],
            ['question_id' => 136, 'answer' => 'Igaz', 'is_correct' => false],
            ['question_id' => 136, 'answer' => 'Hamis', 'is_correct' => true],
            ['question_id' => 137, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 137, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 138, 'answer' => 'new és delete', 'is_correct' => true],
            ['question_id' => 138, 'answer' => 'malloc és free', 'is_correct' => false],
            ['question_id' => 138, 'answer' => 'allocate és deallocate', 'is_correct' => false],
            ['question_id' => 139, 'answer' => 'A pointer aritmetikával növelhetjük vagy csökkenthetjük a pointer értékét, hogy a memóriában más címekre mutasson.', 'is_correct' => true],
            ['question_id' => 139, 'answer' => 'A pointer aritmetikával összeadhatjuk két pointer értékét.', 'is_correct' => false],
            ['question_id' => 139, 'answer' => 'A pointer aritmetikával szorozhatjuk két pointer értékét.', 'is_correct' => false],
        ]);

        DB::table('assignments')->insert([
            [
                'sublesson_id' => 21,
                'title' => 'Memóriakezelés C++ nyelven - Feladatok',
                'markdown' => Storage::get('markdowns/assignments/c/memory_management/memory_management.md'),
                'assignment_xp' => 100
            ],
        ]);

        DB::table('tasks')->insert([
            ['assignment_id' => 21, 'type' => 'quiz', 'title' => 'Memória foglalás alapjai', 'markdown' => 'Ebben a részben a memória foglalás alapvető használatával kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 21, 'type' => 'true_false', 'title' => 'Dinamikus memória kezelés', 'markdown' => 'Ebben a részben a dinamikus memória kezeléssel kapcsolatos kérdéseket találsz.'],
            ['assignment_id' => 21, 'type' => 'checkbox', 'title' => 'Memóriaszivárgás elkerülése', 'markdown' => 'Ebben a részben a memóriaszivárgás elkerülésével kapcsolatos kérdéseket találsz.'],
        ]);

        DB::table('questions')->insert([
            ['task_id' => 67, 'markdown' => 'Mi a dinamikus memória foglalás szerepe a programozásban?'],
            ['task_id' => 67, 'markdown' => 'Hogyan deklarálunk és foglalunk le dinamikus memóriát egy `int` tömb számára C++ nyelven?'],
            ['task_id' => 68, 'markdown' => 'A dinamikusan foglalt memóriát mindig felszabadítjuk a program végén.'],
            ['task_id' => 68, 'markdown' => 'A `malloc` és `calloc` függvények ugyanazt a célt szolgálják, de különböző módon inicializálják a memóriát.'],
            ['task_id' => 69, 'markdown' => 'Melyik függvényeket használjuk dinamikus memória foglalására és felszabadítására C++ nyelven?'],
            ['task_id' => 69, 'markdown' => 'Melyik állítás igaz a memóriaszivárgásokra?'],
        ]);

        DB::table('answers')->insert([
            ['question_id' => 141, 'answer' => 'Adatok dinamikus tárolása és kezelése a futásidő alatt', 'is_correct' => true],
            ['question_id' => 141, 'answer' => 'Változók értékeinek tárolása', 'is_correct' => false],
            ['question_id' => 141, 'answer' => 'Adatok statikus tárolása', 'is_correct' => false],
            ['question_id' => 142, 'answer' => 'int* arr = new int[10];', 'is_correct' => true],
            ['question_id' => 142, 'answer' => 'int arr[10];', 'is_correct' => false],
            ['question_id' => 142, 'answer' => 'int arr = malloc(10);', 'is_correct' => false],
            ['question_id' => 143, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 143, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 144, 'answer' => 'Igaz', 'is_correct' => true],
            ['question_id' => 144, 'answer' => 'Hamis', 'is_correct' => false],
            ['question_id' => 145, 'answer' => 'new és delete', 'is_correct' => true],
            ['question_id' => 145, 'answer' => 'malloc és free', 'is_correct' => true],
            ['question_id' => 145, 'answer' => 'malloc és delete', 'is_correct' => false],
            ['question_id' => 145, 'answer' => 'new és free', 'is_correct' => false],
            ['question_id' => 146, 'answer' => 'A memóriaszivárgások akkor fordulnak elő, ha a dinamikusan foglalt memória felszabadítása elmarad.', 'is_correct' => true],
            ['question_id' => 146, 'answer' => 'A memóriaszivárgások csak a statikusan foglalt memóriával kapcsolatban fordulnak elő.', 'is_correct' => false],
            ['question_id' => 146, 'answer' => 'A memóriaszivárgások nem befolyásolják a program működését.', 'is_correct' => false],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
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
