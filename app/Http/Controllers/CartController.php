<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected function renderCartModal()
    {
        return view('cart.cart-modal')->render();
    }

    protected function renderCartTable()
    {
        // Рендерим только фрагмент корзины
        $html = view('cart.cart-table')->render();
        // Логируем HTML для отладки
        Log::debug('renderCartTable output:', ['html' => substr($html, 0, 500)]);
        return $html;
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        (new Cart())->addToCart($product, $request->qty);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'html' => $this->renderCartModal(),
                'cart_table' => $this->renderCartTable(),
                'cart_qty' => session('cart_qty', 0),
                'cart_total' => session('cart_total', 0),
            ]);
        }

        return redirect()->route('cart.checkout')->with('success', 'Товар добавлен в корзину');
    }

    public function show()
    {
        return response()->json([
            'success' => true,
            'html' => $this->renderCartModal(),
            'cart_qty' => session('cart_qty', 0),
            'cart_total' => session('cart_total', 0),
        ]);
    }

    public function delItem(Request $request, $product_id)
    {
        $cart = new Cart();
        if (!$cart->delItem($product_id)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Товар не найден в корзине',
                ], 404);
            }
            return redirect()->route('cart.checkout')->with('error', 'Товар не найден в корзине');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'html' => $this->renderCartModal(),
                'cart_table' => $this->renderCartTable(),
                'cart_qty' => session('cart_qty', 0),
                'cart_total' => session('cart_total', 0),
            ]);
        }

        return redirect()->route('cart.checkout')->with('success', 'Товар удалён из корзины');
    }

    public function checkout(Request $request)
    {
        return view('cart.checkout');
    }
}
