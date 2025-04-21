

@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Контакты VR-Shop</h1>

        <div class="row">
            <div class="col-md-6">
                <h3>Наши контактные данные:</h3>
                <p><strong>Адрес:</strong> г. Москва, ул. Виртуальная, д. 1</p>
                <p><strong>Телефон:</strong> +7 (123) 456-78-90</p>
                <p><strong>Email:</strong> info@vr-shop.com</p>
            </div>

            <div class="col-md-6">
                <h3>Напишите нам</h3>
                <form>
                    <div class="form-group">
                        <label for="name">Ваше имя:</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите ваше имя">
                    </div>
                    <div class="form-group">
                        <label for="email">Ваш email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Введите ваш email">
                    </div>
                    <div class="form-group">
                        <label for="message">Сообщение:</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Введите ваше сообщение"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
