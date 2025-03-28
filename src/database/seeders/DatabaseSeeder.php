<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1人のユーザーを作成
        $user = User::factory()->create([
            'email' => 'test@example.com', // 固定メールアドレス
            'password' => bcrypt('password'), // 固定パスワード
        ]);

        // そのユーザーに紐づく35件のweight_logsを作成
        WeightLog::factory()->count(35)->create([
            'user_id' => $user->id,
        ]);

        // そのユーザーに紐づく1件のweight_targetを作成
        WeightTarget::factory()->create([
            'user_id' => $user->id,
        ]);
    }
}
