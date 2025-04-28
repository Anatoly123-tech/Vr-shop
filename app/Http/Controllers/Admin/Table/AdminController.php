<?php

namespace App\Http\Controllers\Admin\Table;

use App\Models\Status;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $statuses = Status::all();
        $products = Product::orderBy('created_at', 'desc')->paginate(perPage: 12);
        return view('admin.table.index', compact('products', 'categories', 'statuses'));
    }


    public function create()
    {
        $categories = Category::all();
        $statuses = Status::all();
        return view('admin.table.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'status_id' => 'required|integer|exists:statuses,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $productData = $request->except('img');
        $product = Product::create($productData);

        if ($request->hasFile('img')) {
            $imageName = time() . '_' . $request->file('img')->getClientOriginalName();
            $request->file('img')->move(public_path('assets/front/img'), $imageName);
            $product->img = $imageName;
            $product->save();
        }

        return redirect()->route('admin.table.index')->with('success', 'Товар успешно добавлен!');
    }





    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|integer',
            'status_id' => 'required|integer',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $product->update($request->except('img'));

        if ($request->hasFile('img')) {
            $oldImagePath = public_path('assets/front/img/' . $product->img);
            if ($product->img && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $imageName = time() . '_' . $request->file('img')->getClientOriginalName();
            $request->file('img')->move(public_path('assets/front/img'), $imageName);
            $product->img = $imageName;
            $product->save();
        }

        return redirect()->route('admin.table.index')->with('success', 'Товар успешно обновлен!');
    }





    public function delete(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {
            Product::whereIn('id', $ids)->delete();
            return redirect()->route('admin.table.index')->with('success', 'Товары успешно удалены!');
        }

        return redirect()->route('admin.table.index')->with('error', 'Неверные данные!');
    }
    public function message() {
        $contacts = Contact::all();
        return view('admin.table.message', compact('contacts'));
    }

    public function createCategory()
    {
        $categories = Category::all();
        return view('admin.table.create_category', compact('categories'));
    }
    public function storeCategory(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:categories,title',
        ]);

        Category::create([
            'title'=> $request->title,
        ]);

        return redirect()->route('admin.categories.create')->with('success', 'Категория успешно добавлена!');
    }
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);


        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.create')
                ->with('error', 'Нельзя удалить категорию, так как она содержит товары.');
        }

        $category->delete();

        return redirect()->route('admin.categories.create')
            ->with('success', 'Категория успешно удалена!');
    }
}
