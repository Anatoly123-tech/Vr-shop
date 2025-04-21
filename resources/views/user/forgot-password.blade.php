@extends('layouts.main')
@section('title', 'Home Page')
@section('content')
<h1 class="h2">Забыли пароль</h1>

<p>Введите свой Email для получения ссылки на сброс пароля.</p>

<form action="{{ route('password.email') }}" method="post">
    @csrf 

    <div class="mb-3">
        <label for="email" class="form-label">Электронная почта</label>
        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
        placeholder="Электронная почта" value="{{ old('email') }}">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Отправить</button>

</form>
@endsection