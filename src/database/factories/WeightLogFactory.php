<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class WeightLogFactory extends Factory
{
    protected $model = \App\Models\WeightLog::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // ユーザーに紐づける
            'date' => Carbon::now()->subDays(rand(1, 60))->toDateString(), // 過去60日以内
            'weight' => $this->faker->randomFloat(1, 50, 90), // 50〜90kg
            'calories' => $this->faker->numberBetween(1500, 3000), // 1500〜3000kcal
            'exercise_time' => sprintf('%02d:%02d:00', rand(0, 3), rand(0, 59)), // HH:MM:SS 形式
            'exercise_content' => $this->faker->optional()->sentence(5), // ランダムな運動内容
        ];
    }
}
