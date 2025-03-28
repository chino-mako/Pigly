<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use App\Http\Requests\UpdateWeightLogRequest;
use App\Http\Requests\StoreWeightLogRequest;
use App\Http\Requests\UpdateWeightTargetRequest;
use Illuminate\Support\Facades\Auth;

class WeightController extends Controller
{
    /**
     * 体重管理画面（一覧）
     */
    public function index()
    {
        $user = Auth::user();
        $weightLogs = WeightLog::where('user_id', auth()->id())->paginate(8);

        // 目標体重と最新体重を数値として確実に取得
        $targetWeight = floatval(optional($user->weightTarget)->target_weight ?? 0);
        $latestWeight = floatval(optional($weightLogs->first())->weight ?? 0);

        return view('weight.index', compact('weightLogs', 'targetWeight', 'latestWeight'));
    }

    /**
     * 体重登録画面
     */
    public function create()
    {
        return view('weight.create');
    }

    /**
     * 体重登録処理
     */
    public function store(StoreWeightLogRequest $request)
    {
        // 運動時間を "HH:MM" 形式で受け取る
        $exerciseTime = $request->exercise_time;

        // 変数を事前に定義（エラー防止）
        $exerciseMinutes = 0;

        // HH:MM を "HH:MM:00" に変換（TIME 型に対応）
        if (!empty($exerciseTime) && preg_match('/^(\d{1,2}):(\d{2})$/', $exerciseTime, $matches)) {
            $formattedExerciseTime = sprintf('%02d:%02d:00', (int) $matches[1], (int) $matches[2]);
            $exerciseMinutes = (int) $matches[1] * 60 + (int) $matches[2]; // 分に変換
        } else {
            $formattedExerciseTime = "00:00:00"; // デフォルト値
        }

        WeightLog::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $exerciseMinutes, // 修正された運動時間
            'exercise_details' => $request->exercise_details,
        ]);

        return redirect()->route('weight.index')->with('success', '体重データを登録しました！');
    }

    /**
     * 体重検索
     */
    public function search(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // ユーザーのIDを取得
        $userId = auth()->id();

        // 検索条件に合うデータを取得（古い日付順にソート）
        $weightLogs = WeightLog::where('user_id', $userId)
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->orderBy('date', 'asc') // 古い日付から順番に並べる
            ->paginate(8);

        // 検索結果の件数を取得
        $searchCount = $weightLogs->total();

        // 目標体重と最新体重の取得
        $targetWeight = optional(Auth::user()->weightTarget)->target_weight ?? 0;
        $latestWeight = optional($weightLogs->last())->weight ?? 0; // 最新の体重

        return view('weight.index', compact('weightLogs', 'targetWeight', 'latestWeight', 'searchCount'));
    }


    /**
     * 体重詳細
     */
    public function show($id)
    {
        $log = WeightLog::findOrFail($id);
        return view('weight.show', compact('log'));
    }

    /**
     * 体重編集画面
     */
    public function edit($weightLogId)
    {
        $weightLog = WeightLog::findOrFail($weightLogId); // ID からデータを取得

        return view('weight.edit', compact('weightLog')); // ビューにデータを渡す
    }


    /**
     * 体重更新処理
     */
    public function update(UpdateWeightLogRequest $request, $weightLogId)
    {
        $weightLog = WeightLog::findOrFail($weightLogId);

        $weightLog->update([
            'date' => \Carbon\Carbon::parse($weightLog->date)->format('Y-m-d'),
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_details' => $request->exercise_details,
        ]);

        return redirect()->route('weight.index')->with('success', '体重ログを更新しました！');
    }

    /**
     * 体重削除処理
     */
    public function destroy($weightLogId)
    {
        $weightLog = WeightLog::findOrFail($weightLogId);
        $weightLog->delete();

        return redirect()->route('weight.index')->with('success', '体重ログを削除しました！');
    }

    /**
     * 目標体重設定画面
     */
    public function goalSetting()
    {
        $target = WeightTarget::first();
        return view('weight.goal_setting', compact('target'));
    }

    /**
     * 目標体重保存処理
     */
    public function goalStore(Request $request)
    {
        $request->validate([
            'target_weight' => 'required|numeric|between:0,999.9',
        ]);

        $target = WeightTarget::firstOrNew([]);
        $target->target_weight = $request->target_weight;
        $target->save();

        return redirect()->route('weight.index')->with('success', '目標体重を設定しました！');
    }

    public function target()
    {
        $target = WeightTarget::where('user_id', auth()->id())->first();

        return view('weight.target', compact('target'));
    }

    public function goalUpdate(UpdateWeightTargetRequest $request, $weightTargetId)
    {
        $target = WeightTarget::findOrFail($weightTargetId);
        $target->update([
            'target_weight' => $request->target_weight,
        ]);

        return redirect()->route('weight.index')->with('success', '目標体重を更新しました！');
    }
}