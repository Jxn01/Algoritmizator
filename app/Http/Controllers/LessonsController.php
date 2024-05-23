<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Attempt;
use App\Models\AttemptAnswer;
use App\Models\AttemptQuestion;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Sublesson;
use App\Models\SuccessfulAttempt;
use App\Models\Task;
use App\Models\TaskAttempt;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class LessonsController
 *
 * The LessonsController handles actions related to lessons in the application.
 * This includes getting lessons, assignments, tasks, and submitting assignments.
 */
class LessonsController extends Controller
{
    /**
     * Get all lessons.
     *
     * This method returns all lessons in the system.
     * Each lesson includes information about the sublessons associated with it.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse The lessons in the system.
     */
    public function getLessons(Request $request): JsonResponse
    {
        $response = [];
        $lessons = Lesson::all();

        foreach ($lessons as $lesson) {
            $response[] = [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'sublessons' => $lesson->sublessons,
            ];
        }

        return response()->json($response);
    }

    /**
     * Get a specific lesson.
     *
     * This method returns a specific lesson in the system.
     * The lesson includes information about the sublessons associated with it.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @param int $id  The ID of the lesson.
     * @return JsonResponse The lesson.
     */
    public function getAssignmentAndTasks(Request $request, int $id): JsonResponse
    {
        $assignment = Sublesson::find($id)->assignment;
        $tasks = $assignment->tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'markdown' => $task->markdown,
                'type' => $task->type,
                'questions' => $task->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'markdown' => $question->markdown,
                        'answers' => $question->answers->map(function ($answer) {
                            return [
                                'id' => $answer->id,
                                'answer' => $answer->answer,
                                'is_correct' => $answer->is_correct,
                            ];
                        }),
                    ];
                }),
            ];
        });

        return response()->json([
            'assignment' => $assignment,
            'tasks' => $tasks,
        ]);
    }

    /**
     * Submit an assignment.
     *
     * This method submits an assignment with the user's answers.
     * It calculates the total score and determines if the user passed the assignment.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse The result of the submission.
     */
    public function submitAssignment(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'assignment_id' => 'required|integer|exists:assignments,id',
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|integer|exists:tasks,id',
            'tasks.*.questions' => 'required|array',
            'tasks.*.questions.*.id' => 'required|integer|exists:questions,id',
            'tasks.*.questions.*.answer' => 'required',
            'time' => 'required|integer|min:0',
        ]);

        $user = auth()->user();
        $assignment = Assignment::findOrFail($validatedData['assignment_id']);
        $totalScore = 0;
        $maxScore = 0;

        $attempt = Attempt::create([
            'user_id' => $user->id,
            'assignment_id' => $assignment->id,
            'total_score' => 0,
            'max_score' => 0,
            'time' => gmdate('H:i:s', $validatedData['time']),
            'passed' => false,
        ]);

        foreach ($validatedData['tasks'] as $taskData) {
            $task = Task::findOrFail($taskData['id']);
            $taskMaxScore = $task->questions->count();
            $taskScore = 0;

            $taskAttempt = TaskAttempt::create([
                'attempt_id' => $attempt->id,
                'task_id' => $task->id,
            ]);

            foreach ($taskData['questions'] as $questionData) {
                $question = Question::findOrFail($questionData['id']);
                $questionScore = 0;

                $attemptQuestion = AttemptQuestion::create([
                    'task_attempt_id' => $taskAttempt->id,
                    'question_id' => $question->id,
                ]);

                if ($task->type === 'result') {
                    $submittedAnswer = $questionData['answer'];
                    $correctAnswer = $question->answers->first()->answer;

                    AttemptAnswer::create([
                        'attempt_question_id' => $attemptQuestion->id,
                        'custom_answer' => $submittedAnswer,
                    ]);

                    if (trim($submittedAnswer) === trim($correctAnswer)) {
                        $questionScore = 1;
                    }
                } else {
                    $submittedAnswers = is_array($questionData['answer']) ? $questionData['answer'] : [$questionData['answer']];
                    $correctAnswers = $question->answers->where('is_correct', true)->pluck('id')->toArray();

                    foreach ($submittedAnswers as $submittedAnswerId) {
                        AttemptAnswer::create([
                            'attempt_question_id' => $attemptQuestion->id,
                            'answer_id' => $submittedAnswerId,
                        ]);

                        if (in_array($submittedAnswerId, $correctAnswers)) {
                            $questionScore++;
                        } else {
                            $questionScore--;
                        }
                    }
                    $questionScore >= count($correctAnswers) * 0.5 ? $questionScore = 1 : $questionScore = 0;
                }

                $taskScore += $questionScore;
            }

            $totalScore += $taskScore;
            $maxScore += $taskMaxScore;
        }

        $passed = ($totalScore / $maxScore) >= 0.7;
        if ($passed) {
            $successfulAttempt = SuccessfulAttempt::where('user_id', $user->id)
                ->where('assignment_id', $assignment->id)
                ->first();

            if (! $successfulAttempt) {
                SuccessfulAttempt::create([
                    'user_id' => $user->id,
                    'assignment_id' => $assignment->id,
                    'attempt_id' => $attempt->id,
                ]);

                $user = User::findById($user->id);
                $user->update([
                    'total_xp' => $user->total_xp + $assignment->assignment_xp,
                ]);
                $user->save();
            } else {
                $previousAttempt = $successfulAttempt->attempt;
                if ($totalScore > $previousAttempt->total_score) {
                    $successfulAttempt->update([
                        'attempt_id' => $attempt->id,
                    ]);
                    $successfulAttempt->save();
                }
            }

        }

        $attempt->update([
            'total_score' => $totalScore,
            'max_score' => $maxScore,
            'passed' => $passed,
        ]);

        return response()->json([
            'message' => 'Assignment submitted successfully',
            'attempt_id' => $attempt->id,
        ]);
    }

    /**
     * Get an attempt.
     *
     * This method returns an attempt with the user's answers.
     *
     * @param int $id  The ID of the attempt.
     * @return JsonResponse The attempt.
     */
    public function getAttempt(int $id): JsonResponse
    {
        $attempt = Attempt::with([
            'assignment',
            'tasks.task',
            'tasks.questions.question.answers',
            'tasks.questions.attemptAnswers',
        ])->findOrFail($id);

        $data = [
            'id' => $attempt->id,
            'user_id' => $attempt->user_id,
            'assignment' => [
                'id' => $attempt->assignment->id,
                'title' => $attempt->assignment->title,
                'markdown' => $attempt->assignment->markdown,
            ],
            'tasks' => $attempt->tasks->map(function ($taskAttempt) {
                return [
                    'id' => $taskAttempt->task->id,
                    'title' => $taskAttempt->task->title,
                    'markdown' => $taskAttempt->task->markdown,
                    'type' => $taskAttempt->task->type,
                    'questions' => $taskAttempt->questions->map(function ($attemptQuestion) {
                        $question = $attemptQuestion->question;

                        return [
                            'id' => $question->id,
                            'markdown' => $question->markdown,
                            'type' => $question->type,
                            'submitted_answers' => $attemptQuestion->attemptAnswers->map(function ($attemptAnswer) {
                                return [
                                    'id' => $attemptAnswer->id,
                                    'answer_id' => $attemptAnswer->answer_id,
                                    'custom_answer' => $attemptAnswer->custom_answer,
                                    'answer' => $attemptAnswer->answer ? $attemptAnswer->answer->answer : null,
                                    'is_correct' => $attemptAnswer->answer ? $attemptAnswer->answer->is_correct : null,
                                ];
                            }),
                            'answers' => $question->answers->map(function ($answer) {
                                return [
                                    'id' => $answer->id,
                                    'answer' => $answer->answer,
                                    'is_correct' => $answer->is_correct,
                                ];
                            }),
                        ];
                    }),
                ];
            }),
            'total_score' => $attempt->total_score,
            'max_score' => $attempt->max_score,
            'time' => $attempt->time,
            'passed' => $attempt->passed,
        ];

        return response()->json($data);
    }

    /**
     * Get all attempts.
     *
     * This method returns all attempts of the current user.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse The attempts of the current user.
     */
    public function getAllAttempts(Request $request): JsonResponse
    {
        $user = auth()->user();

        $attempts = Attempt::with([
            'assignment',
            'tasks.task',
            'tasks.questions.question',
            'tasks.questions.answers.answer',
        ])->where('user_id', $user->id)->get();

        $data = $attempts->map(function ($attempt) {
            return [
                'id' => $attempt->id,
                'user_id' => $attempt->user_id,
                'assignment' => [
                    'id' => $attempt->assignment->id,
                    'title' => $attempt->assignment->title,
                    'markdown' => $attempt->assignment->markdown,
                ],
                'tasks' => $attempt->tasks->map(function ($taskAttempt) {
                    return [
                        'id' => $taskAttempt->task->id,
                        'title' => $taskAttempt->task->title,
                        'markdown' => $taskAttempt->task->markdown,
                        'type' => $taskAttempt->task->type,
                        'questions' => $taskAttempt->questions->map(function ($attemptQuestion) {
                            return [
                                'id' => $attemptQuestion->question->id,
                                'markdown' => $attemptQuestion->question->markdown,
                                'type' => $attemptQuestion->question->type,
                                'submitted_answers' => $attemptQuestion->answers->map(function ($attemptAnswer) {
                                    return [
                                        'id' => $attemptAnswer->id,
                                        'answer_id' => $attemptAnswer->answer_id,
                                        'custom_answer' => $attemptAnswer->custom_answer,
                                        'answer' => $attemptAnswer->answer ? $attemptAnswer->answer->answer : null,
                                        'is_correct' => $attemptAnswer->answer ? $attemptAnswer->answer->is_correct : null,
                                    ];
                                }),
                                'correct_answers' => $attemptQuestion->question->answers->where('is_correct', true)->pluck('id'),
                            ];
                        }),
                    ];
                }),
                'total_score' => $attempt->total_score,
                'max_score' => $attempt->max_score,
                'time' => $attempt->time,
                'passed' => $attempt->passed,
            ];
        });

        return response()->json($data);
    }

    /**
     * Get successful attempts.
     *
     * This method returns all successful attempts of the user.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @param int $id  The ID of the user.
     * @return JsonResponse The successful attempts of the user.
     */
    public function getSuccessfulAttempts(Request $request, int $id): JsonResponse
    {
        $successfulAttempts = SuccessfulAttempt::with([
            'assignment',
            'assignment.sublesson',
            'attempt',
        ])->where('user_id', $id)->get();

        $data = $successfulAttempts->map(function ($successfulAttempt) {
            return [
                'id' => $successfulAttempt->attempt->id,
                'title' => $successfulAttempt->assignment->title,
                'assignment_xp' => $successfulAttempt->assignment->assignment_xp,
                'total_score' => $successfulAttempt->attempt->total_score,
                'max_score' => $successfulAttempt->attempt->max_score,
                'time' => $successfulAttempt->attempt->time,
                'created_at' => $successfulAttempt->attempt->created_at,
                'sublesson_id' => $successfulAttempt->assignment->sublesson->id,
            ];
        });

        return response()->json($data);
    }

    /**
     * Get the hourly lesson.
     *
     * This method returns the lessonfor the current hour.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @return JsonResponse The hourly lesson.
     */
    public function getHourlyLesson(Request $request): JsonResponse
    {
        $hour = date('H') + 1;
        if($hour > 21){
            $hour -= 20;
        }
        $lesson = Sublesson::where('id', $hour)->first();

        return response()->json([
            'id' => $lesson->id,
            'title' => $lesson->title,
            'markdown' => $lesson->markdown,
        ]);
    }
}
