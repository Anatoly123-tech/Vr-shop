<table class="table">
    <thead>
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Количество</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if (empty(session('cart')))
            <tr>
                <td colspan="5" class="text-center">Корзина пуста</td>
            </tr>
        @else
            @foreach (session('cart') as $item)
                <tr>
                    <td>
                        <img src="{{ $item['img'] ?? asset('assets/front/img/no-image.png') }}" alt="{{ $item['title'] }}" class="img-fluid" style="max-width: 50px;" onerror="console.log('Image failed to load: {{ $item['img'] }}');">
                    </td>
                    <td>{{ $item['title'] }}</td>
                    <td>{{ number_format($item['price']) }} руб.</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm del-item" data-action="{{ route('cart.del_item', $item['product_id']) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="text-end">
    <strong>Итого: <span id="modal-cart-qty">{{ session('cart_qty', 0) }}</span> шт., {{ number_format(session('cart_total', 0)) }} руб.</strong>
</div>
@if (!empty(session('cart')))
    <script>
        console.log('Showing btn-cart');
        document.querySelector('.btn-cart').classList.remove('d-none');
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.del-item').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const action = this.getAttribute('data-action');
                console.log('Sending GET request to:', action);
                fetch(action, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {

                        const modalContent = document.querySelector('.modal-content');
                        if (modalContent) {
                            modalContent.innerHTML = data.html;
                        }

                        const cartQtyElement = document.querySelector('#cart-qty');
                        if (cartQtyElement) {
                            cartQtyElement.textContent = data.cart_qty;
                        }

                        if (data.cart_qty === 0) {
                            document.querySelector('.btn-cart').classList.add('d-none');
                        }
                    } else {
                        alert(data.message || 'Ошибка при удалении товара');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Ошибка при удалении товара: ' + error.message);
                });
            });
        });
    });
</script>
