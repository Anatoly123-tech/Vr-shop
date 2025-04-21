<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $title = 'Home Page';
        $products = Product::with(['category', 'status'])->orderBy('id', 'desc')->paginate(10);
        return view('products.index', compact('title', 'products'));
    }

    public function show($slug)
    {
        $product = Product::query()->with(['category', 'status'])->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

}
