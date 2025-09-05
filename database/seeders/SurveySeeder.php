<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;

class SurveySeeder extends Seeder
{
    public function run(): void
    {
        Survey::create([
            'title' => 'Customer Satisfaction',
            'description' => 'Survey about customer experience',
            'status' => 'active'
        ]);

        Survey::create([
            'title' => 'Product Feedback',
            'description' => 'Survey about product quality',
            'status' => 'active'
        ]);
    }
}

