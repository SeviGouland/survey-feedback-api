<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            ->firstOrFail(); 

        return response()->json([
            'data' => $survey
        ]);
    }
    
 public function submit(Request $request, $id)
{
    $survey = Survey::findOrFail($id);
    $responder = Auth::user();

    // check if the survey is active
    if ($survey->status !== 'active') {
        $this->logSubmission([
            'survey_id' => $survey->id,
            'responder_id' => $responder?->id,
        ], false, 403, 'Inactive survey');

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

    foreach ($validated['answers'] as $item) {
        $question = Question::findOrFail($item['question_id']);
        if ($question->survey_id !== $survey->id) {
            $this->logSubmission([
                'survey_id' => $survey->id,
                'responder_id' => $responder?->id,
                'question_id' => $question->id,
            ], false, 400, "Question ID {$question->id} does not belong to this survey");

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

    $this->logSubmission([
        'responder_id' => $responder->id,
        'survey_id' => $survey->id,
        'answers' => $validated['answers'],
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Answers submitted successfully.'
    ]);
}

private function logSubmission(array $data, bool $success = true, int $status = 200, ?string $errorMessage = null)
{
    $logData = array_merge([
        'success' => $success,
        'status_code' => $status,
        'error' => $errorMessage,
        'submitted_at' => now()->toDateTimeString(),
        'ip' => request()->ip(),
    ], $data);

    Storage::disk('local')->append('survey_submissions.json', json_encode($logData));
}

}
