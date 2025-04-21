@extends('layouts.main')
@section('title', 'Регистрация')
@section('content')

    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="product-card col-md-6">
           
                <h1 class="h2 text-center">Регистрация</h1>
                <form action="{{ route('user.store') }}" method="post">
                    @csrf

                 
                    <div class="mb-4">
                        <label for="name" class="form-label">Имя</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" placeholder="Введите ваше имя" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                   
                    <div class="mb-4">
                        <label for="email" class="form-label">Электронная почта</label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="Введите ваш email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Пароль</label>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="Введите пароль">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Повторите пароль</label>
                        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation"
                            placeholder="Повторите пароль">
                    </div>

                    
                    <div class="text-center">
                        <button type="submit" class="btn cart-btn">Регистрация</button>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-muted">Уже зарегистрированы?</a>
                    </div>
                </form>
            
        </div>
    </div>

@endsection
