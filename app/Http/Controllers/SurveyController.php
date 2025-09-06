<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;


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

}
