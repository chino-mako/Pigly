<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WeightController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//会員登録画面
Route::get('/register/step1', [RegisterController::class, 'showRegistrationForm'])->name('register.step1');
Route::post('/register/step1', [RegisterController::class, 'register']);

//初期体重登録画面
Route::get('/register/step2', [RegisterController::class, 'showInitialWeightForm'])->name('register.step2');
Route::post('/register/step2', [RegisterController::class, 'storeInitialWeight']);


//ログイン画面
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.process');

//体重管理画面
Route::middleware(['auth'])->group(function () {
    Route::get('/weight_logs', [WeightController::class, 'index'])->name('weight.index'); // トップページ（一覧）
    Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
    })->name('logout');
    Route::get('/weight_logs/create', [WeightController::class, 'create'])->name('weight.create'); // 体重登録画面
    Route::post('/weight_logs/store', [WeightController::class, 'store'])->name('weight.store'); // 体重登録処理
    Route::get('/weight_logs/search', [WeightController::class, 'search'])->name('weight.search'); // 体重検索
    Route::get('/weight_logs/{weightLogId}', [WeightController::class, 'show'])->name('weight.show'); // 体重詳細
    Route::get('/weight_logs/{weightLogId}/edit', [WeightController::class, 'edit'])->name('weight.edit'); // 体重編集画面
    Route::put('/weight_logs/{weightLogId}/update', [WeightController::class, 'update'])->name('weight.update'); // 体重更新処理
    Route::delete('/weight_logs/{weightLogId}/delete', [WeightController::class, 'destroy'])->name('weight.delete'); // 体重削除処理
    Route::get('/weight_logs/goal_setting', [WeightController::class, 'goalSetting'])->name('weight.goal'); // 目標体重設定画面
    Route::post('/weight_logs/goal_store', [WeightController::class, 'goalStore'])->name('weight.goal.store'); // 目標体重保存処理
    Route::get('/weight/target', [WeightController::class, 'target'])->name('weight.target'); // 目標体重変更処理
    Route::put('/weight/target/update/{weightTargetId}', [WeightController::class, 'goalUpdate'])
    ->name('weight.goalUpdate'); // 目標体重更新処理
});