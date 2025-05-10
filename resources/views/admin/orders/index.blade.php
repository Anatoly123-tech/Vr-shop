@extends('layouts.admin')

@section('content')
    <style>
        .action-buttons .btn+.btn {
            margin-left: 15px;
            /* Горизонтальный отступ между кнопками */

        }

        .status-select {
            min-width: 200px;
            /* Минимальная ширина select */
            margin-bottom: 10px;
            /* Вертикальный отступ снизу для select */
        }
    </style>
    <h1>Список заказов</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($orders && $orders->count() > 0)
                            @php
                                // Объявляем функцию один раз перед циклом
                                function decodeUnicode($str)
                                {
                                    return preg_replace_callback(
                                        '/\\\\u([0-9a-fA-F]{4})/',
                                        function ($match) {
                                            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
                                        },
                                        $str,
                                    );
                                }
                            @endphp
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Имя</th>
                                        <th>Почта</th>
                                        <th>Телефон</th>
                                        <th>Адрес</th>
                                        <th>Продукты</th>
                                        <th>Количество</th>
                                        <th>Сумма</th>
                                        <th>Дата</th>
                                        <th>Статус</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone ?? 'Не указан' }}</td>
                                            <td>{{ $order->address ?? 'Не указан' }}</td>
                                            <td>
                                                @php
                                                    $products = json_decode($order->products, true);
                                                @endphp
                                                @if (is_array($products) && !empty($products))
                                                    @foreach ($products as $product_id => $product)
                                                        <li> {{ decodeUnicode($product['title']) }}</li>
                                                    @endforeach
                                                @else
                                                    <p>Нет данных</p>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    @foreach ($products as $product)
                                                        <li>• {{ $product['qty'] }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>{{ number_format($order->total_price) }} руб.</td>
                                            <td>
                                                @if ($order->order_date instanceof \Carbon\Carbon)
                                                    {{ $order->order_date->format('d.m.Y H:i') }}
                                                @elseif (is_string($order->order_date))
                                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d.m.Y H:i') }}
                                                @else
                                                    Не указана
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                                    {{ $order->status == 'pending' ? 'Ожидание' : ($order->status == 'approved' ? 'Одобрен' : 'Отказано') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <form action="{{ route('admin.orders.updateStatus', $order) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="input-group">
                                                            <select name="status" class="form-control status-select w-100">
                                                                <option value="pending"
                                                                    {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                                    Ожидание</option>
                                                                <option value="approved"
                                                                    {{ $order->status == 'approved' ? 'selected' : '' }}>
                                                                    Одобрен</option>
                                                                <option value="rejected"
                                                                    {{ $order->status == 'rejected' ? 'selected' : '' }}>
                                                                    Отказано</option>
                                                            </select>
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                style="margin-bottom: 10px;">Подтвердить</button>
                                                        </div>
                                                    </form>
                                                    <form action="{{ route('admin.orders.destroy', $order) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Удалить весь заказ?')">
                                                            <i class="fas fa-trash-alt"></i> Удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Заказы отсутствуют.</p>
                        @endif
                    </div>
                    <div class="card-footer">
                        @if ($orders && $orders->count() > 0)
                            {{ $orders->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
