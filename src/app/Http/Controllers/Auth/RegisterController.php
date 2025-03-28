<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\InitialWeightRequest;

class RegisterController extends Controller
{
    //会員登録画面
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        // ユーザー作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 自動ログイン
        Auth::login($user);

        // 初期目標体重登録画面へリダイレクト
        return redirect()->route('register.step2')->with('success', 'アカウントが作成されました！');
    }

    //初期体重登録画面
    public function showInitialWeightForm()
    {
        return view('auth.initial');
    }

    public function storeInitialWeight(InitialWeightRequest $request)
    {
        $user = Auth::user();

        // ✅ weight_logs テーブルに現在の体重を記録
        $user->weightLogs()->create([
            'user_id' => $user->id,
            'date' => now(), // 登録日
            'weight' => $request->weight, // 入力された体重
        ]);

        // ✅ 目標体重を weight_target テーブルに保存
        $user->weightTarget()->updateOrCreate(
            ['user_id' => $user->id],
            ['target_weight' => $request->target_weight]
        );

        return redirect()->route('weight.index')->with('success', '体重データを登録しました');
    }


}
