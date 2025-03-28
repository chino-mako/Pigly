<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weight_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('weight', 5, 1);
            $table->integer('calories')->nullable();
            $table->time('exercise_time')->nullable();
            $table->text('exercise_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weight_logs');
    }

    // モデル (WeightLog) でアクセサを使って、exercise_timeを秒数に変換
    public function getExerciseTimeInSecondsAttribute()
    {
        // exercise_timeはtime型なので、HH:MM:SS形式の文字列です
        if ($this->exercise_time) {
            $timeParts = explode(":", $this->exercise_time); // "HH:MM:SS" を分割
            return ($timeParts[0] * 3600) + ($timeParts[1] * 60) + ($timeParts[2] ?? 0); // 秒に変換
        }
        return 0;
    }

}
