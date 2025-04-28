@extends('layouts.admin')
@section('content')
<div class="container">
    <h1>Обратная свзяь</h1>

    <table class="table">
        <thead>
            <tr>
                <td>Имя пользователя</td>
                <td>Электронная почта</td>
                <td>Сообщение</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{$contact->name}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->message}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
