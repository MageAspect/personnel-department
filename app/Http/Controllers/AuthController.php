<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth');
    }

    public function processLoginForm(LoginRequest $request)
    {
        $data = $request->validated();

        if (auth('web')->attempt($data)) {
            return redirect(route('departments'));
        }

        return redirect()->back()->withErrors([
            'auth' => 'Неверный логин или пароль'
        ])->withInput();
    }

    public function showForgotPasswordForm()
    {
        return view('forgot-password', ['mailSent' => !empty(session('mail-sent'))]);
    }

    public function processForgotPasswordForm(ForgotPasswordRequest $request)
    {
        $data = $request->validated();

        return redirect()->back()->with('mail-sent', true)->withInput();
    }
}
