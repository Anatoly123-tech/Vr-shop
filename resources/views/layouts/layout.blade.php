<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/front/img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}?v={{ time() }}">
</head>
<body>
    @include('layouts.navbar')

    <div class="wrapper mt-5">
        <div class="container">
            @yield('breadcrumbs')
            @yield('content')
        </div>
    </div>

    <div class="modal fade cart-modal" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Корзина</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-cart @if(empty(session('cart'))) d-none @endif">
                        Оформить заказ
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-body-tertiary text-center">
        <div class="container p-4">
            <img src="{{ asset('assets/front/img/logo.png') }}" alt="Vr-Shop" class="navbar-logo">
            <section class="mb-4">
                <a class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-telegram"></i></a>
                <a class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-youtube"></i></a>
                <a class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>
                <a class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-vk"></i></a>
                <a class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
            </section>
            <section class="mb-4">
                <div class="d-flex flex-wrap justify-content-center">
                    <div class="me-4">
                        <h5 class="text-uppercase">Информация</h5>
                        <ul class="list-unstyled">
                            <li><a class="text-body" href="{{ route('about') }}" style="text-decoration: none;">О компании</a></li>
                            <li><a class="text-body" href="{{ route('pages.contact') }}" style="text-decoration: none;">Контакты</a></li>
                        </ul>
                    </div>
                    <div class="me-4">
                        <h5 class="text-uppercase">Категории</h5>
                        <ul class="list-unstyled">
                            <li><a class="text-body" href="{{ route('categories.show', ['slug' => 'Shlem-Ochki']) }}" style="text-decoration: none;">Шлем - очки</a></li>
                            <li><a class="text-body" href="{{ route('categories.show', ['slug' => 'Aksessyari']) }}" style="text-decoration: none;">Аксессуары</a></li>
                            <li><a class="text-body" href="{{ route('categories.show', ['slug' => 'Computers']) }}" style="text-decoration: none;">Компьютеры</a></li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            <a class="text-reset fw-bold" href="{{ route('home') }}">VR-Shop</a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/front/js/main.js') }}?v={{ time() }}"></script>
</body>
</html>
