@extends('layouts.layout')

@section('title') @parent  {{ $title }} @endsection

@section('content')
<div class="container">
    <div id="productCarousel" class="carousel slide mb-5" data-ride="carousel" style="max-width: 800px; margin: auto;">
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

        <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Предыдущее</span>
        </a>
        <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Следующее</span>
        </a>
    </div>
</div>

<div class="container product-cards mb-5">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-3 col-sm-6 mb-4 d-flex">
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
                <div class="item-status mt-2"><i class="{{ $product->status->icon }}"></i> {{ $product->status->title }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="col-md-12">
    <nav aria-label="Page navigation example">
        {{ $products->links('pagination.custom') }}
    </nav>
</div>
@endsection
