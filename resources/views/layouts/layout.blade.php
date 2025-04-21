<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}">

    <title>@yield('title', 'Laravel Shop')</title>

</head>

<body>


    <div id="preloader">
        <div class="loader"></div>
    </div>

    @include('layouts.navbar')


    <div class="wrapper mt-5">
        <div class="container">
            <div class="row">

                @yield('content')

            </div>
        </div>
    </div>
    <div class="modal fade cart-modal" id="cart-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Корзина</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                            </tr>
                        </thead>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-cart @if(empty(session('cart'))) d-none @endif">
                        Оформить заказ</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/front/js/main.js') }}"></script>

    <footer class="bg-body-tertiary text-center">

        <div class="container p-4">
            <img src="{{asset('assets/front/img/logo.png') }}" alt="Vr-Shop" class="navbar-logo">

            <section class="mb-4">
                <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
                <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>
                <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>
                <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>
                <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
                <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
            </section>

            <section class="mb-4">
                <div class="d-flex flex-wrap justify-content-center">
                    <div class="mr-4">
                        <h5 class="text-uppercase">Информация</h5>
                        <ul class="list-unstyled">
                            <li><a class="text-body" href="{{ route('about') }}">О компании</a></li>
                            <li><a class="text-body" href="{{ route('blog') }}">Блог</a></li>
                            <li><a class="text-body" href="{{ route('contact') }}">Контакты</a></li>
                        </ul>
                    </div>
                    <div class="mr-4">
                        <h5 class="text-uppercase">Категории</h5>
                        <ul class="list-unstyled">
                            <li><a class="text-body" href="{{ route('categories.show', ['slug' => 'Shlem - Ochki']) }}">Шлем - очки</a></li>
                            <li><a class="text-body" href="{{ route('categories.show', ['slug' => 'Aksessyari']) }}">Аксессуары</a></li>
                            <li><a class="text-body" href="{{ route('categories.show', ['slug' => 'Computers']) }}">Компьютеры</a></li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>


        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2020 Copyright:
            <a class="text-reset fw-bold" href="{{route('home') }}">VR-Shop</a>
        </div>
    </footer>

</body>w
</html>
