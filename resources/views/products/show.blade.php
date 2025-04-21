@extends('layouts.layout')

@section('title') @parent  {{ $product->title }} @endsection

@section('content')

<div class="col-md-12">
    <h1>{{ $product->title }}</h1>
</div>

<div class="col-md-3">
    <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-thumbnail">
</div>

<div class="col-sm-8">
    <ul class="list-unstyled">
        <li>Категория:
            <a href="{{ route('categories.show', ['slug' => $product->category->slug]) }}">
                {{ $product->category->title }}
            </a>
        </li>
        <li>Наличие: <i class="{{ $product->status->icon }}"></i>{{ $product->status->title }}</li>
        <li>Цена:
            <span class="cart-price text-center">
                @if($product->old_price)
                <del><small>@price_format($product->old_price) руб.</small></del>
                @endif
                @price_format($product->price) руб.
            </span>
        </li>
    </ul>

    <form action="{{ route('cart.add') }}" method="post" class="addtocart">
        @csrf
        <div class="form-row">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" name="qty" value="1">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="input-group-append">
                        <button class="btn btn-info btn-block cart-addtocart" type="submit">
                            <i class="fas fa-cart-arrow-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <div class="container mt-4">
    <div class="text-center mb-3">
        <ul class="nav nav-tabs justify-content-center" id="productTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
                    Описание
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="productTabContent">
        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
            <div class="product-desc">
                {{ $product->content }}
            </div>
        </div>
    </div>
</div>
</div>

@endsection