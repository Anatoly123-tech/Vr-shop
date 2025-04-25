@extends('layouts.layout')

@section('title') @parent {{ $title }} @endsection

@section('content')
<div class="container">
    <section class="about-section mb-5 text-center">
        <h2>Добро пожаловать в VR-Shop!</h2>
        <p class="lead">
            VR-Shop — ваш надежный проводник в мир виртуальной реальности. Мы предлагаем лучшие VR-шлемы, аксессуары и компьютеры для полного погружения в цифровую реальность.
        </p>
    </section>
    <div id="productCarousel" class="carousel slide mb-5 my-carousel" data-bs-ride="carousel" style="max-width: 800px; margin: auto;">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/front/img/vr.jpg') }}" alt="Изображение 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/front/img/vr2.jpg') }}" alt="Изображение 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/front/img/vr3.jpg') }}" alt="Изображение 3">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/front/img/vr4.jpg') }}" alt="Изображение 4">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/front/img/vr5.jpg') }}" alt="Изображение 5">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Предыдущее</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Следующее</span>
        </button>
    </div>
    <section class="advantages-section mb-5">
        <h2 class="text-center mb-4">Почему выбирают нас?</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="advantage-card text-center">
                    <i class="fas fa-shipping-fast fa-2x mb-3"></i>
                    <h5>Быстрая доставка</h5>
                    <p>Доставляем заказы по всей России в кратчайшие сроки.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="advantage-card text-center">
                    <i class="fas fa-shield-alt fa-2x mb-3"></i>
                    <h5>Гарантия качества</h5>
                    <p>Все товары сертифицированы и проходят проверку.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="advantage-card text-center">
                    <i class="fas fa-box-open fa-2x mb-3"></i>
                    <h5>Широкий ассортимент</h5>
                    <p>VR-шлемы, аксессуары и компьютеры для любых задач.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="new-products-section mb-5">
        <h2 class="text-center mb-4">Новинки</h2>
        <div id="newProductsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @if($newProducts->isEmpty())
                <div class="carousel-item active">
                    <p class="text-center">Новинки пока отсутствуют.</p>
                </div>
                @else
                @php
                    $chunkedProducts = $newProducts->chunk(3);
                @endphp
                @foreach($chunkedProducts as $index => $chunk)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row">
                        @foreach($chunk as $product)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="product-card">
                                <div class="card-thumb text-center">
                                    <a href="{{ route('products.show', ['slug' => $product->slug]) }}">
                                        <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="cart-caption text-center mt-3">
                                    <div class="card-title">
                                        <a href="{{ route('products.show', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
                                    </div>
                                    <div class="cart-price">
                                        @if($product->old_price)
                                        <del><small>{{ $product->old_price }} руб.</small></del>
                                        @endif
                                        <strong>{{ $product->price }} руб.</strong>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add') }}" method="post" class="addtocart mt-2">
                                    @csrf
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="qty" value="1" min="1">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-info cart-addtocart" type="submit">
                                                <i class="fas fa-cart-arrow-down"></i> Купить
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#newProductsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Предыдущее</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#newProductsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Следующее</span>
            </button>
        </div>
    </section>
    <div class="row">
        <div class="col-lg-3 order-lg-2">
            <button class="btn btn-primary d-lg-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                Показать фильтры
            </button>
            <div class="filter-form collapse d-lg-block" id="filterCollapse">
                <form method="GET" action="{{ route('home') }}">
                    <div class="form-group mb-3 position-relative">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" name="title" id="title" class="form-control ps-5"
                               value="{{ $filters['title'] ?? '' }}" placeholder="Введите название товара">
                        <i class="fas fa-search position-absolute filter-icon"></i>
                    </div>
                    <div class="form-group mb-3 position-relative">
                        <label for="min_price" class="form-label">Мин. цена</label>
                        <input type="number" name="min_price" id="min_price" class="form-control ps-5"
                               value="{{ $filters['min_price'] ?? '' }}" placeholder="0" min="0">
                        <i class="fas fa-ruble-sign position-absolute filter-icon"></i>
                    </div>
                    <div class="form-group mb-3 position-relative">
                        <label for="max_price" class="form-label">Макс. цена</label>
                        <input type="number" name="max_price" id="max_price" class="form-control ps-5"
                               value="{{ $filters['max_price'] ?? '' }}" placeholder="100000" min="0">
                        <i class="fas fa-ruble-sign position-absolute filter-icon"></i>
                    </div>
                    <button type="submit" class="btn btn-primary">Применить</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Сбросить</a>
                </form>
            </div>
        </div>
        <!-- Товары (9 колонок) -->
        <div class="col-lg-9 order-lg-1">
            <div class="product-cards mb-5">
                <div class="row">
                    @forelse ($products as $product)
                    <div class="col-md-4 col-sm-6 mb-4 d-flex">
                        <div class="product-card flex-grow-1 d-flex flex-column">
                            <div class="card-thumb text-center">
                                <a href="{{ route('products.show', ['slug' => $product->slug]) }}">
                                    <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-fluid">
                                </a>
                            </div>
                            <div class="cart-caption text-center mt-3 flex-grow-1">
                                <div class="card-title">
                                    <a href="{{ route('products.show', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
                                </div>
                                <div class="cart-price">
                                    @if($product->old_price)
                                    <del><small>{{ $product->old_price }} руб.</small></del>
                                    @endif
                                    <strong>{{ $product->price }} руб.</strong>
                                </div>
                            </div>
                            <form action="{{ route('cart.add') }}" method="post" class="addtocart mt-2">
                                @csrf
                                <div class="input-group">
                                    <input type="number" class="form-control" name="qty" value="1" min="1">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-info cart-addtocart" type="submit">
                                            <i class="fas fa-cart-arrow-down"></i> Купить
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="item-status mt-2"><i class="{{ $product->status->icon }}"></i> {{ $product->status->title }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <p>Товары не найдены.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <nav aria-label="Page navigation example" class="pagination-centered">
                {{ $products->appends($filters)->links('pagination.custom') }}
            </nav>
        </div>
    </div>
</div>
@endsection
