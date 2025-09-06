<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {

        Question::create([
            'survey_id' => 1,
            'type' => 'scale',
            'question_text' => 'How satisfied are you with your last purchase? (1-5)'
        ]);

        Question::create([
            'survey_id' => 2,
            'type' => 'scale',
            'question_text' => 'How likely are you to recommend our products to your friends? (1-5)'
        ]);

        Question::create([
            'survey_id' => 3,
            'type' => 'multiple_choice',
            'question_text' => 'Which part of our service did you like the most?'
        ]);


        Question::create([
            'survey_id' => 3,
            'type' => 'text',
            'question_text' => 'Tell us a few words about your experience with our service.'
        ]);
    }
}
