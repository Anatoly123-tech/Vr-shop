@extends('layouts.layout')

@section('title')
    Мои заказы
@endsection

@section('content')
    <div class="container">
        <h1>Мои заказы</h1>
        @if ($orders && $orders->count() > 0)
            @php
                // Объявляем функцию один раз перед циклом
                function decodeUnicode($str) {
                    return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
                    }, $str);
                }
            @endphp
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Изображение</th>
                        <th>Название товара</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Статус</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @php
                            $products = json_decode($order->products, true);
                        @endphp
                        @if (is_array($products) && !empty($products))
                            <tr>
                                <td>
                                    @foreach ($products as $product)
                                        <img src="{{ $product['img'] ?? asset('assets/front/img/placeholder.png') }}" alt="{{ decodeUnicode($product['title']) }}" style="max-width: 50px; display: block; margin-bottom: 5px;">
                                    @endforeach
                                </td>
                                <td>
                                    <ul class="list-unstyled">
                                        @foreach ($products as $product)
                                            <li>{{ decodeUnicode($product['title']) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul class="list-unstyled">
                                        @foreach ($products as $product)
                                            <li>{{ $product['qty'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ number_format($order->total_price, 2) }} руб.</td>
                                <td>
                                    <span class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                        {{ $order->status == 'pending' ? 'Ожидание' : ($order->status == 'approved' ? 'Одобрен' : 'Отказано') }}
                                    </span>
                                </td>
                                <td>
                                    @if ($order->order_date instanceof \Carbon\Carbon)
                                        {{ $order->order_date->format('d.m.Y H:i') }}
                                    @elseif (is_string($order->order_date))
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('d.m.Y H:i') }}
                                    @else
                                        Не указана
                                    @endif
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="6">Нет данных о товарах</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <p>У вас нет заказов.</p>
        @endif
    </div>
@endsection
