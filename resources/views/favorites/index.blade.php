<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Избранное</title>
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}">
</head>
<body>
    @extends('layouts.layout')

    @section('title') Избранное @endsection

    @section('breadcrumbs')
        @include('partials.breadcrumbs', [
            'items' => [
                ['title' => 'Главная', 'url' => route('home')],
                ['title' => 'Избранное', 'url' => null]
            ]
        ])
    @endsection

    @section('content')
        <div class="container">
            <h1>Избранное</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($favorites->isEmpty())
                <p>У вас нет избранных товаров.</p>
            @else
                <div class="row product-cards">
                    @foreach ($favorites as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="product-card">
                                <div class="card-thumb">
                                    <img src="{{ $product->getImage() }}" alt="{{ $product->title }}">
                                </div>
                                <div class="card-caption">
                                    <div class="card-title">
                                        <a href="{{ route('products.show', $product->slug) }}">{{ Str::limit($product->title, 50) }}</a>
                                    </div>
                                    <div class="cart-price">
                                        @if($product->old_price)
                                            <del><small>@price_format($product->old_price) руб.</small></del>
                                        @endif
                                        Цена:@price_format($product->price) руб.
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagination-centered">
                    {{ $favorites->links() }}
                </div>
            @endif
        </div>
    @endsection
</body>
</html>
