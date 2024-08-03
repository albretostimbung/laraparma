<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->take(6)->get();
        $categories = Category::all();

        return view('front.index', compact('products', 'categories'));
    }

    public function details(Product $product)
    {
        return view('front.details', compact('product'));
    }

    public function category(Category $category)
    {
        return view('front.category', compact('category'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::where('name', 'like', '%' . strtolower($keyword) . '%')->get();

        return view('front.search', compact('products', 'keyword'));
    }

    public function success()
    {
        return view('front.success');
    }
}
