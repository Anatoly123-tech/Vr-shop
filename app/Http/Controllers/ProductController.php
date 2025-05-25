<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Home Page';
        $query = Product::with(['category', 'status']);

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->input('status_id'));
        }
        $categories = Category::all();
        $statuses = Status::all();

        $sort = $request->query('sort', 'id_desc');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
        }
        $products = $query->orderBy('id', 'desc')->paginate(12);
        $newProducts = Product::with(['category', 'status'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('products.index', compact('title', 'products', 'newProducts', 'categories', 'statuses') + [
            'filters' => $request->only(['title', 'min_price', 'max_price', 'sort', 'category_id', 'status_id'])
        ]);
    }

    public function show($slug)
    {
        $product = Product::query()->with(['category', 'status', 'images'])->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('admin.table.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products',
            'content' => 'required|string',
            'category_id' => 'required|integer',
            'status_id' => 'required|integer',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'img' => 'nullable|string',
            'hit' => 'boolean',
            'sale' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно добавлен!');
    }

    public function delete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids)) {
            Product::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Товары успешно удалены!']);
        }

        return response()->json(['error' => 'Неверные данные!'], 400);
    }
}
