<?php
namespace App\Models;

class Cart
{
    public function addToCart(Product $product, int $qty)
    {
        $cart = session('cart', []);

        // Проверяем, есть ли товар в корзине
        $existingItemIndex = null;
        foreach ($cart as $index => $item) {
            if ($item['product_id'] == $product->id) {
                $existingItemIndex = $index;
                break;
            }
        }

        if ($existingItemIndex !== null) {
            // Увеличиваем количество
            $cart[$existingItemIndex]['qty'] += $qty;
        } else {
            // Добавляем новый товар
            $cart[] = [
                'product_id' => $product->id,
                'title' => $product->title,
                'img' => $product->getImage(),
                'price' => $product->price,
                'qty' => $qty,
                'slug' => $product->slug,
            ];
        }

        // Обновляем сессию
        session(['cart' => $cart]);

        // Обновляем общее количество и сумму
        $this->updateCartTotals();
    }

    public function delItem($product_id)
    {
        $cart = session('cart', []);
        $updated = false;

        // Ищем товар в корзине
        foreach ($cart as $index => $item) {
            if ($item['product_id'] == $product_id) {
                if ($item['qty'] > 1) {
                    // Уменьшаем количество на 1
                    $cart[$index]['qty'] -= 1;
                    $updated = true;
                } else {
                    // Удаляем товар, если qty == 1
                    unset($cart[$index]);
                    $updated = true;
                }
                break;
            }
        }

        // Переиндексируем массив
        $cart = array_values($cart);

        if (!$updated) {
            return false; // Товар не найден
        }

        // Обновляем сессию
        session(['cart' => $cart]);

        // Обновляем общее количество и сумму
        $this->updateCartTotals();

        return true;
    }

    protected function updateCartTotals()
    {
        $cart = session('cart', []);
        $totalQty = 0;
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalQty += $item['qty'];
            $totalPrice += $item['price'] * $item['qty'];
        }

        session([
            'cart_qty' => $totalQty,
            'cart_total' => $totalPrice,
        ]);
    }
}
