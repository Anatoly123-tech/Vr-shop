@if (!empty(session('cart')))
    <div class="table-responsive cart-table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Фото</th>
                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Кол-во</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('cart') as $item)
                    <tr>
                        <td>
                            <a href="{{ route('products.show', ['slug' => $item['slug']]) }}">
                                <img src="{{ $item['img'] ?? asset('assets/front/img/no-image.png') }}" alt="{{ $item['title'] }}" style="max-width: 50px;" onerror="console.log('Image failed to load: {{ $item['img'] }}');">
                            </a>
                        </td>
                        <td><a href="{{ route('products.show', ['slug' => $item['slug']]) }}">{{ $item['title'] }}</a></td>
                        <td>{{ number_format($item['price']) }} руб.</td>
                        <td>{{ $item['qty'] }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm del-item" data-action="{{ route('cart.del_item', $item['product_id']) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" align="right">Итого:</td>
                    <td id="cart-qty-total">{{ session('cart_qty', 0) }}</td>
                </tr>
                <tr>
                    <td colspan="4" align="right">На сумму:</td>
                    <td id="cart-price-total">{{ number_format(session('cart_total', 0)) }} руб.</td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <h4>Корзина пуста</h4>
    <p>Добавьте товары в корзину, чтобы оформить заказ.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Вернуться на главную</a>
@endif
