@extends('layouts.layout')

@section('title') @parent {{ $category->title }} @endsection
@section('breadcrumbs')

        @include('partials.breadcrumbs', [
            'items' => [
                ['title' => 'Главная', 'url' => route('home')],
                ['title' => 'Категории', 'url' => route('home')],
                ['title' => $category->title, 'url' => null]
            ]
        ])
@endsection
@section('content')
<div class="container">

    <h1 class="mb-4">{{ $category->title }}</h1>


    <div class="row">
        <div class="col-lg-3 order-lg-2">
            <button class="btn btn-success d-lg-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                <i class="bi bi-filter"></i>
            </button>
            <div class="filter-form collapse d-lg-block" id="filterCollapse">
                <form method="GET" action="{{ route('categories.show', ['slug' => $category->slug]) }}">
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
                    <button type="submit" class="btn btn-success">Применить</button>
                    <a href="{{ route('categories.show', ['slug' => $category->slug]) }}" class="btn btn-secondary">Сбросить</a>
                </form>
            </div>
        </div>
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
                                            <i class="fas fa-cart-arrow-down"></i> В корзину                                     </button>
                                    </div>
                                </div>
                            </form>
                            <div class="item-status mt-2"><i class="{{ $product->status->icon }}"></i> {{ $product->status->title }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <p>В этой категории пока нет товаров...</p>
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
