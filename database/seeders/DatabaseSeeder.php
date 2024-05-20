<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

          // Buat pengguna baru menggunakan factory
        $user = User::factory()->create();

        $quiz = Quiz::create([
            'title' => 'Sample Quiz',
            'user_id' => $user->id,
        ]);

        $question1 = Question::create([
            'quiz_id' => $quiz->id,
            'text' => 'What is the capital of France?',
            'type' => 'multiple_choice',
        ]);

        Option::create([
            'question_id' => $question1->id,
            'text' => 'Paris',
            'is_correct' => true,
            'points' => 10,
        ]);

        Option::create([
            'question_id' => $question1->id,
            'text' => 'London',
            'is_correct' => false,
            'points' => 0,
        ]);

        Option::create([
            'question_id' => $question1->id,
            'text' => 'Berlin',
            'is_correct' => false,
            'points' => 0,
        ]);

        $question2 = Question::create([
            'quiz_id' => $quiz->id,
            'text' => 'What is 2 + 2?',
            'type' => 'multiple_choice',
        ]);

        Option::create([
            'question_id' => $question2->id,
            'text' => '4',
            'is_correct' => true,
            'points' => 10,
        ]);

        Option::create([
            'question_id' => $question2->id,
            'text' => '3',
            'is_correct' => false,
            'points' => 0,
        ]);

        Option::create([
            'question_id' => $question2->id,
            'text' => '5',
            'is_correct' => false,
            'points' => 0,
        ]);
    }
}
