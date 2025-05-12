<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->title }}</title>
</head>
<body>
    @extends('layouts.layout')

    @section('title') @parent {{ $product->title }} @endsection

    @section('breadcrumbs')
        @include('partials.breadcrumbs', [
            'items' => [
                ['title' => 'Главная', 'url' => route('home')],
                ['title' => $product->category ? $product->category->title : 'Товары', 'url' => $product->category ? route('categories.show', ['slug' => $product->category->slug]) : route('home')],
                ['title' => $product->title, 'url' => null]
            ]
        ])
    @endsection

    @section('content')
        <div class="col-md-12">
            <h1>{{ $product->title }}</h1>
        </div>

        <div class="col-md-3">
            <div class="row">
               
                <div class="col-12 mb-3">
                    <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-thumbnail thumbnail w-100" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ $product->getImage() }}" style="cursor: pointer;">
                </div>

                <div class="col-12">
                    <div class="d-flex flex-wrap">
                        @php
                            $images = $product->getImages();
                            \Log::info('Product Images in show.blade.php:', $images);
                        @endphp
                        @if (!empty($images))
                            @foreach ($images as $image)
                                <div class="me-2 mb-2">
                                    <img src="{{ $image }}" alt="{{ $product->title }}" class="img-thumbnail thumbnail" style="width: 80px; height: 80px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ $image }}">
                                </div>
                            @endforeach
                        @else
                            <p>Нет дополнительных изображений</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">{{ $product->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ $product->getImage() }}" alt="{{ $product->title }}" class="img-fluid" id="modalImage">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <ul class="list-unstyled">
                <li>Категория:
                    <a href="{{ route('categories.show', ['slug' => $product->category->slug]) }}" style="text-decoration: none; color:black;">
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

            <div class="d-flex align-items-center mb-3">
                <form action="{{ route('cart.add') }}" method="post" class="addtocart mr-3">
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

                @auth
                    <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn {{ Auth::user()->favorites()->where('product_id', $product->id)->exists() ? 'btn-danger' : 'btn-outline-secondary' }}">
                            <i class="fas fa-heart"></i>
                        </button>
                    </form>
                @endauth
            </div>

            <div class="container mt-4">
                <div class="text-center mb-3">
                    <ul class="nav nav-tabs justify-content-center" id="productTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">
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

    @section('scripts')
        <script>
            console.log('Script loaded');

            document.addEventListener('DOMContentLoaded', function () {
                console.log('DOMContentLoaded fired');

                const modalImage = document.getElementById('modalImage');
                const thumbnails = document.querySelectorAll('.thumbnail');

                console.log('Found thumbnails:', thumbnails.length);

                if (!modalImage) {
                    console.error('Modal image element not found');
                    return;
                }

                thumbnails.forEach(thumbnail => {
                    thumbnail.addEventListener('click', function () {
                        const imageUrl = this.getAttribute('data-image');
                        console.log('Clicked thumbnail with URL:', imageUrl);
                        if (imageUrl) {
                            modalImage.src = imageUrl;
                        } else {
                            console.error('No data-image attribute found on thumbnail');
                        }
                    });
                });
            });
        </script>
    @endsection
</body>
</html>
