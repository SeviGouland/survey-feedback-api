<?php

namespace Database\Seeders;

use App\Models\Responder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResponderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Responder::create([
            'email' => 'sevigouland@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        Responder::create([
            'email' => 'example@gmail.com',
            'password' => Hash::make('password1234'),
        ]);

        Responder::create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password12345'),
        ]);
    }
}
