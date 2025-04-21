<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;




class UserController extends Controller
{


    public function forgotPasswordStore(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordUpdate(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:2|confirmed',
        ]);
        $request['password'] = Hash::make($request->password);



        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $requestData = $request->all();
        $requestData['password'] = bcrypt($request->password);

        $user = User::create($requestData);

        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('verification.notice');
    }

    public function dashboard()
    {
        return redirect()->route('home');
    }

    public function login()
    {
        return view('user.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function loginAuth(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();


            return redirect()->route('home')->with('success', 'Добро пожаловать, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Некорректный логин или пароль',
        ]);
    }
}
