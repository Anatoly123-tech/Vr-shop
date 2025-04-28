@if (isset($onlyTable) && $onlyTable)
    @include('cart.cart-table')
@else
    @extends('layouts.layout')

    @section('title')
        Оформление заказа
    @endsection

    @section('breadcrumbs')
    @include('partials.breadcrumbs', [
        'items' => [
            ['title' => 'Главная', 'url' => route('home')],
            ['title' => 'Категории', 'url' => route('home')],
            ['title' => 'Оформление заказа', 'url' => null]
        ]
    ])
@endsection
    @section('content')
        <div class="col-md-12 cart-container">
            <h1>Оформление заказа</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @include('cart.cart-table')

            @if (!empty(session('cart')))
                <form method="POST" action="{{ route('order.store') }}" class="order-form" id="checkoutForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Телефон</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Адрес доставки</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="confirmPurchase" required>
                        <label class="form-check-label" for="confirmPurchase">Я подтверждаю покупку товара</label>
                    </div>
                    <input type="hidden" name="products" value="{{ json_encode(session('cart'), JSON_UNESCAPED_UNICODE) }}">
                    <input type="hidden" name="total_price" value="{{ session('cart_total', 0) }}">
                    <button type="submit" class="btn btn-primary">Оформить заказ</button>
                </form>
            @endif
        </div>
    @endsection
@endif
