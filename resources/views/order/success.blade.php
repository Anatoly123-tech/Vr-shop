@extends('layouts.layout')

@section('title')
    Заказ оформлен
@endsection

@section('content')
    <div class="col-md-12">
        <h1>Заказ успешно оформлен!</h1>
        <div class="alert alert-success">
            Спасибо за ваш заказ! Мы свяжемся с вами для подтверждения.
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary">Вернуться на главную</a>
    </div>
@endsection
