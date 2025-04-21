@extends('layouts.main')
@section('title', 'Авторизация')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="product-card col-md-6">
            <h1 class="h2 text-center">Авторизация</h1>
            <form action="{{ route('login.auth') }}" method="post">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">Электронная почта</label>
                    <input name="email" type="email" class="form-control" id="email"
                        placeholder="Введите вашу почту">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Пароль</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Введите пароль">
                </div>

                <div class="mb-4 form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Запомнить меня
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn cart-btn">Войти</button>
                </div>
                <div class="text-center">
                    <br><a href="{{ route('password.request') }}" class="ms-2">Забыли пароль?</a>
                </div>
                <div class="text-center">
                    <a href="{{ route('register') }}" class="btn btn-link">Еще нет аккаунта?</a>
                </div>
            </form>
        </div>
    </div>
@endsection
