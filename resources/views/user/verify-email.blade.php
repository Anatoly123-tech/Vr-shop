@extends('layouts.main')

@section('title', 'Home page')

@section('content')

<div class="alert alert-info" role="alert">
    Спасибо большое за регистрацию!
    Вам придет сообщение о подтверждении аккаунта на почту.
</div>
<div>
    <form method="post" action="{{ route('verification.send') }}">
        @csrf 
        <button type="submit" class="btn btn-link ps-0">Отправить заново</button>
    </form>
</div>

@endsection