<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    public function getLessons(Request $request)
    {
        $response = [];
        $lessons = Lesson::all();

        foreach($lessons as $lesson)
        {
            $response[] = [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'sublessons' => $lesson->sublessons
            ];
        }

        return response()->json($response);
    }

    public function getQuiz($id)
    {
        $lesson = Lesson::find($id);

        return response()->json($lesson);
    }

    public function submitQuiz(Request $request, $id)
    {

    }

    public function getAttempts($id)
    {

    }


}
