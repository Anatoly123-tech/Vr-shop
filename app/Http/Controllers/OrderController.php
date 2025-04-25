<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        if (empty(session('cart'))) {
            return redirect()->route('cart.checkout')->with('error', 'Корзина пуста. Добавьте товары перед оформлением заказа.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'products' => 'required|string',
            'total_price' => 'required|numeric|min:0',
        ]);

        $products = json_decode(stripslashes($validated['products']), true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($products) || empty($products)) {
            return redirect()->route('cart.checkout')->with('error', 'Ошибка: некорректные данные о товарах.');
        }

        $productsArray = array_values($products);

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? 'Не указан',
            'products' => json_encode($productsArray, JSON_UNESCAPED_UNICODE),
            'total_price' => $validated['total_price'],
            'status' => 'pending',
            'order_date' => now(),
        ]);

        $request->session()->forget(['cart', 'cart_qty', 'cart_total']);

        return redirect()->route('order.success')->with('success', 'Заказ успешно оформлен! Ждем вас на выдаче товара!');
    }

    public function index()
    {
        $orders = Order::with('user')->orderBy('order_date', 'desc')->paginate(12);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);
        $order->update(['status' => $request->status]);
        return redirect()->route('admin.orders.index')->with('success', 'Статус заказа обновлён!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Заказ успешно удалён!');
    }

    public function success()
    {
        return view('order.success');
    }
    public function userOrders()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('order_date', 'desc')->get();
        return view('user.orders', compact('orders'));
    }
}
