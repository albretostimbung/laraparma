<?php

namespace App\Http\Controllers\Product;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if (!$request->hasFile('photo')) {
                    return;
                }

                $photoPath = $request->file('photo')->store('product_photos', 'public');
                $validated = array_merge($request->validated(), [
                    'photo' => $photoPath
                ]);

                Product::create($validated + [
                    'slug' => Str::slug($request->name),
                ]);
            });

            return redirect()->route('admin.products.index');
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use ($request, $product) {
                if (!$request->hasFile('photo')) {
                    $photoPath = $product->photo;
                    $validated = array_merge($request->validated(), [
                        'photo' => $photoPath
                    ]);

                    $product->update($validated + [
                        'slug' => Str::slug($request->name),
                    ]);

                    return;
                }

                $photoPath = $request->file('photo')->store('product_photos', 'public');
                $validated = array_merge($request->validated(), [
                    'photo' => $photoPath
                ]);

                Product::create($validated + [
                    'slug' => Str::slug($request->name),
                ]);
            });

            return redirect()->route('admin.products.index');
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index');
    }
}
