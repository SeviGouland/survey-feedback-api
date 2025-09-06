<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{

    // get list with all the active surveys
    public function index()
    {
        $surveys = Survey::where('status', '=', 'active')->get();

        return response()->json([
            'data' => $surveys
        ]);
    }

    // get survey details with questions
    public function show($id)
    {
        $survey = Survey::with('questions')
            ->where('id', $id)
            ->firstOrFail(); // 404 if it doesn't exist

        return response()->json([
            'data' => $survey
        ]);
    }

 public function submit(Request $request, $id)
{
    $survey = Survey::findOrFail($id);

    // check if the survey is active
    if ($survey->status !== 'active') {
        return response()->json([
            'success' => false,
            'message' => 'This survey is inactive. You cannot submit.'
        ], 403); 
    }

    $validated = $request->validate([
        'answers' => 'required|array',
        'answers.*.question_id' => 'required|exists:question,id',
        'answers.*.response_data' => 'required|array',
    ]);

    $responder = Auth::user(); 

    foreach ($validated['answers'] as $item) {
        // checking that the question belongs to the specific survey
        $question = Question::findOrFail($item['question_id']);
        if ($question->survey_id !== $survey->id) {
            return response()->json([
                'success' => false,
                'message' => "Question ID {$question->id} does not belong to this survey."
            ], 400);
        }

        Answer::create([
            'responder_id' => $responder->id,
            'question_id' => $item['question_id'],
            'response_data' => $item['response_data'],
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Answers submitted successfully.'
    ]);
}





}
