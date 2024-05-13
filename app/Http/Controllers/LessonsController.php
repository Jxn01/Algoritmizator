<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Attempt;
use App\Models\AttemptAnswer;
use App\Models\Lesson;
use App\Models\Sublesson;
use App\Models\TaskAttempt;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    public function getLessons(Request $request)
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

    public function getAssignmentAndTasks(Request $request, $id)
    {
        $assignment = Sublesson::find($id)->assignment;
        $tasks = $assignment->tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'markdown' => $task->markdown,
                'type' => $task->type,
                'answers' => $task->answers->map(function ($answer) {
                    return [
                        'id' => $answer->id,
                        'answer' => $answer->answer,
                        'is_correct' => $answer->is_correct,
                    ];
                }),
            ];
        });

        return response()->json([
            'assignment' => $assignment,
            'tasks' => $tasks,
        ]);
    }

    public function submitAssignment(Request $request, $id)
    {
        $assignment = Sublesson::find($id)->assignment;
        $tasks = $assignment->tasks;
        $answers = $request->input('answers');
        $time = $request->input('time');

        $attempt = new Attempt();
        $attempt->user_id = auth()->user()->id;
        $attempt->assignment_id = $assignment->id;

        foreach ($tasks as $task) {
            new TaskAttempt([
                'task_id' => $task->id,
                'attempt_id' => $attempt->id,
            ]);
        }

        foreach($answers as $answer) {
            $attemptAnswer = new AttemptAnswer();
            $attemptAnswer->task_attempt_id = $answer['task_id'];
            $attemptAnswer->answer_id = $answer['answer_id'];
            $attemptAnswer->custom_answer = $answer['custom_answer'];
            $attemptAnswer->save();
        }

        foreach ($tasks as $task) {
            $taskAnswers = [];
            foreach ($answers as $answer) {
                if ($answer['task_id'] == $task->id) {
                    $taskAnswers[] = $answer;
                }
            }
            $maxScore += 1;
            $correctAnswer = null;
            if ($task->type == 'quiz') {
                $correctAnswer = $task->answers->where('is_correct', true)->first()->id;
                $userAnswer = $taskAnswers[0]['answer_id'];
                if($correctAnswer == $userAnswer) {
                    $totalScore += 1;
                }
            } else if($task->type == 'open') {
                $correctAnswer = $task->answers->where('is_correct', true)->first()->answer;
                $userAnswer = $taskAnswers[0]['custom_answer'];
                if($correctAnswer == $userAnswer) {
                    $totalScore += 1;
                }
            } else if($task->type == 'multiple') {
                $correctAnswers = $task->answers->where('is_correct', true)->pluck('id');
                $userAnswers = collect($taskAnswers)->pluck('answer_id');
                if($correctAnswers->diff($userAnswers)->isEmpty() && $userAnswers->diff($correctAnswers)->isEmpty()) {
                    $totalScore += 1;
                }
            } else if($task->type == 'true_false'){
                $correctAnswers = $task->answers->where('is_correct', true)->pluck('id');
                $userAnswers = collect($taskAnswers)->pluck('answer_id');
                if($correctAnswers->diff($userAnswers)->isEmpty() && $userAnswers->diff($correctAnswers)->isEmpty()) {
                    $totalScore += 1;
                }
            }
        }

        if ($totalScore < $maxScore / 3 * 2) {
            $passed = false;
        }

        $attempt->total_score = $totalScore;
        $attempt->max_score = $maxScore;
        $attempt->time = $time;
        $attempt->passed = $passed;
        $attempt->save();

        return redirect()->route('task-attempt', ['id' => $id, 'resultId' => $attempt->id]);
    }

    public function getAttempts($id)
    {
        $attempts = Attempt::where('assignment_id', $id)->where('user_id', auth()->user()->id)->get();
        $attempts = $attempts->map(function ($attempt) {
            return [
                'id' => $attempt->id,
                'assignment_id' => $attempt->assignment_id,
                'total_score' => $attempt->total_score,
                'max_score' => $attempt->max_score,
                'time' => $attempt->time,
                'passed' => $attempt->passed,
                'created_at' => $attempt->created_at,
            ];
        });

        return response()->json($attempts);
    }

    public function getAttempt($id, $resultId)
    {
        $attempt = Attempt::where('assignment_id', $id)->where('user_id', auth()->user()->id)->where('id', $resultId)->first();
        $attempt = [
            'id' => $attempt->id,
            'assignment_title' => $attempt->assignment->title,
            'assignment_markdown' => $attempt->assignment->markdown,
            'assignment_xp' => $attempt->assignment->assignment_xp,
            'total_score' => $attempt->total_score,
            'max_score' => $attempt->max_score,
            'time' => $attempt->time,
            'passed' => $attempt->passed,
            'created_at' => $attempt->created_at,
            'taskAttempts' => $attempt->tasks->map(function ($taskAttempt) {
                return [
                    'id' => $taskAttempt->id,
                    'task_title' => $taskAttempt->task->title,
                    'task_markdown' => $taskAttempt->task->markdown,
                    'task_type' => $taskAttempt->task->type,
                    'answers' => $taskAttempt->answers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'answer' => $answer->answer->answer,
                            'is_correct' => $answer->answer->is_correct,
                            'custom_answer' => $answer->custom_answer,
                        ];
                    }),
                ];
            }),
        ];

        return response()->json($attempt);
    }
}
