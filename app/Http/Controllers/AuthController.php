<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\SendResetPasswordLink;
use App\Mail\ForgotPasswordMail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function processLoginForm(LoginRequest $request)
    {
        $data = $request->validated();

        if (auth('web')->attempt($data)) {
            return redirect(route('departments'));
        }

        return back()->withErrors([
            'auth' => 'Неверный логин или пароль'
        ])->withInput();
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password', ['mailSent' => !empty(session('mail-sent'))]);
    }

    public function processForgotPasswordForm(ForgotPasswordRequest $request)
    {
        $email = $request->validated()['email'];

        $status = Password::sendResetLink(array('email' => $email), function (CanResetPassword $user, string $token) {
            $this->dispatch(new SendResetPasswordLink($user, $token));
        });

        if ($status == Password::RESET_THROTTLED) {
            return back()->withErrors([
                'reset' => 'Отправлять запрос на восстановление можно максимум один раз в минуту'
            ])->withInput();
        }

        if ($status == Password::INVALID_TOKEN) {
            return back()->withErrors([
                'reset' => 'Ошибка отправки запроса. Попробуйте позже'
            ])->withInput();
        }

        return back()->with('mail-sent', true)->withInput();
    }

    public function showResetPasswordForm(string $token, Request $request)
    {
        if (!$this->isValidReset($request->get('email'), $token)) {
            return redirect()->route('auth.forgot-password');
        }

        return view(
            'auth.password-reset',
            [
                'passwordWasReset' => !empty(session('password-was-reset')),
                'email' => $request->get('email'),
                'token' => $token,
            ]
        );
    }

    public function processResetPasswordForm(ResetPasswordRequest $request)
    {
        $request->validated();

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status = Password::PASSWORD_RESET) {
            return redirect()->route('auth.reset-password-success');
        }

        return back()->withErrors(['reset' => 'Не удалось изменить пароль']);
    }

    public function isValidReset(string $email, string $token): bool
    {
        $user = Password::getUser(['email' => $email]);
        if (!$user || !Password::tokenExists($user, $token)) {
            return false;
        }

        return true;
    }
}
