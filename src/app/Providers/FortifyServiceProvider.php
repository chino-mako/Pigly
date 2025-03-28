<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Fortify の登録画面のビューを指定（重要！）
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // RegisterViewResponse のバインディングを設定
        $this->app->singleton(RegisterViewResponse::class, function () {
            return new class implements RegisterViewResponse {
                public function toResponse($request)
                {
                    return view('auth.register');
                }
            };
        });

        // ✅ Fortify のログイン画面のビューを指定
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // ✅ ユーザー登録・プロファイル更新・パスワードリセットの設定
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // ✅ Fortify のカスタム認証（LoginRequest → Request に修正）
        Fortify::authenticateUsing(function (Request $request) {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return Auth::user();
            }

            return null;
        });

        // ✅ ログイン試行回数の制限（5回/分）
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        // ✅ 2要素認証の制限
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::redirects('login', '/dashboard'); // ログイン後のリダイレクト先
        Fortify::redirects('register', '/dashboard'); // 登録後のリダイレクト先
        Fortify::redirects('logout', '/'); // ログアウト後のリダイレクト先
    }
}
