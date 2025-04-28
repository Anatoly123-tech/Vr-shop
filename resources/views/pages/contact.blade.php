@extends('layouts.layout')

@section('title') @parent Контакты @endsection
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Контакты</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="contact-info card p-4 shadow-sm">
                <h3>Наши контактные данные</h3>
                <p><strong>Адрес:</strong> г. Тюмень, ул. Виртуальная, д. 1</p>
                <p><strong>Телефон:</strong> <a href="tel:+71234567890">+7 (969) 805-72-96</a></p>
                <p><strong>Email:</strong> <a href="mailto:info@vr-shop.com">tolyshimarev@gmail.com</a></p>

                <h4 class="mt-4">Часы работы</h4>
                <ul class="list-unstyled">
                    <li><strong>Пн-Пт:</strong> 10:00–19:00</li>
                    <li><strong>Сб:</strong> 11:00–17:00</li>
                    <li><strong>Вс:</strong> Выходной</li>
                </ul>

                <h4 class="mt-4">Мы в соцсетях</h4>
                <div class="social-links">
                    <a href="https://t.me/vrshop" target="_blank" class="me-3" title="Telegram">
                        <i class="fab fa-telegram-plane fa-2x"></i>
                    </a>
                    <a href="https://vk.com/vrshop" target="_blank" class="me-3" title="ВКонтакте">
                        <i class="fab fa-vk fa-2x"></i>
                    </a>
                    <a href="https://instagram.com/vrshop" target="_blank" title="Instagram">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="contact-form card p-4 shadow-sm">
                <h3 style="text-align: center;">Отправьте сообщение через форму обратной связи</h3>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Ваше имя:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Введите ваше имя" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Ваш email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Введите ваш email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="message" class="form-label">Сообщение:</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Введите ваше сообщение" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Отправить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
