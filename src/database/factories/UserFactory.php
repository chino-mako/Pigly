<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name('ja_JP'), // 日本人の名前
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // 初期パスワード
        ];
    }
}
