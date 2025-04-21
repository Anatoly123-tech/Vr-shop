@extends('layouts.layout')

@section('title') @parent  {{ $category->title }} @endsection

@section('content')
<div class="container product-cards mb-5">
    <div class="row">
        @forelse ($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex">
            <div class="product-card">
                <div class="card-thumb text-center">
                    <a href="{{ route('products.show', ['slug' => $product->slug]) }}">
                        <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-fluid">
                    </a>
                </div>
                <div class="cart-caption mt-3">
                    <div class="card-title">
                        <a href="{{ route('products.show', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
                    </div>
                    <div class="cart-price text-center">
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
        <div class="col-12">
            <p class="text-center">В этой категории пока нет товаров...</p>
        </div>
        @endforelse
    </div>
</div>
<div class="col-md-12">
    <nav aria-label="Page navigation example">
        {{ $products->links() }}
    </nav>
</div>
@endsection
