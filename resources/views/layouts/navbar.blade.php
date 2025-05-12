<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/front/img/logo.png') }}" alt="Vr-Shop" class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Каталог
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        @foreach ($categories as $category)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('categories.show', ['slug' => $category->slug]) }}">
                                    {{ $category->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <button onclick="getCart('{{ route('cart.show') }}')" type="button" class="btn cart-btn">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        Корзина
                        <span class="badge badge-light mini-cart-qty ml-1">{{ session('cart_qty') ?? 0 }}</span>
                    </button>
                </li>
            </ul>
            <ul class="navbar-nav mx-auto">
                <li><a class="nav-link" href="{{ route('about') }}">О компании</a></li>
                <li><a class="nav-link" href="{{ route('pages.contact') }}">Контакты</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->email === 'tolyshimarev@gmail.com')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Админ-панель</a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.orders') }}">Заказы</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('favorites.index') }}">Избранное</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}">Выйти</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Войти</a>
                        </li>
                    @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>
