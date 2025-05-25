<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, $slug)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();
        $query = $category->products()->with(['category', 'status']);

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->input('status_id'));
        }
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
        $statuses = Status::all();
        $products = $query->orderBy('id', 'desc')->paginate(12);

        return view('categories.show', compact('category', 'products', 'statuses') + [
            'filters' => $request->only(['title', 'min_price', 'max_price', 'sort', 'status_id'])
        ]);
    }
}
