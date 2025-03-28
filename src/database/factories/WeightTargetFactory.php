<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WeightTargetFactory extends Factory
{
    protected $model = \App\Models\WeightTarget::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // ユーザーに紐づける
            'target_weight' => $this->faker->randomFloat(1, 50, 70), // 50〜70kg
        ];
    }
}
