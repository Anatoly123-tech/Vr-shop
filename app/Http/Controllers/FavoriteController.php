<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Product $product)
    {
        $user = Auth::user();

        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);
            $message = 'Товар удален из избранного.';
        } else {
            $user->favorites()->attach($product->id);
            $message = 'Товар добавлен в избранное.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function index()
    {
        $favorites = Auth::user()->favorites()->with('category', 'status')->paginate(12);
        return view('favorites.index', compact('favorites'));
    }
}
