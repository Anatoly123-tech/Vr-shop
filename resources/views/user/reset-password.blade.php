@extends('layouts.main')
@section('title', 'Home Page')
@section('content')
<h1 class="h2">Cбросить пароль</h1>

<form action="{{ route('password.update') }}" method="post">
    @csrf 
    <input type="hidden" name="token" value="{{$token}}">

    <div class="mb-3">
        <label for="email" class="form-label">Электронная почта</label>
        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
        placeholder="Электронная почта" value="{{ old('email') }}">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password"
        placeholder="Пароль">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Подтверждения пароля</label>
        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Подтверждение пароля">
    </div>

    <button type="submit" class="btn btn-primary">Сбросить пароль</button>

</form>
@endsection
