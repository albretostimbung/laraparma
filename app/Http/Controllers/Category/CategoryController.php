<?php

namespace App\Http\Controllers\Category;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                if (!$request->hasFile('icon')) {
                    return;
                }

                $iconPath = $request->file('icon')->store('category_icons', 'public');
                $validated = array_merge($request->validated(), [
                    'icon' => $iconPath
                ]);

                Category::create($validated + [
                    'slug' => Str::slug($request->name),
                ]);
            });

            return redirect()->route('admin.categories.index');
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            DB::transaction(function () use ($request, $category) {
                if (!$request->hasFile('icon')) {
                    $iconPath = $category->icon;
                    $validated = array_merge($request->validated(), [
                        'icon' => $iconPath
                    ]);

                    $category->update($validated + [
                        'slug' => Str::slug($request->name),
                    ]);

                    return;
                }

                $iconPath = $request->file('icon')->store('category_icons', 'public');
                $validated = array_merge($request->validated(), [
                    'icon' => $iconPath
                ]);

                $category->update($validated + [
                    'slug' => Str::slug($request->name),
                ]);
            });

            return redirect()->route('admin.categories.index');
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }
}
