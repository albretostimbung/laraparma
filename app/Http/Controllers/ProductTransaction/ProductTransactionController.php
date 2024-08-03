<?php

namespace App\Http\Controllers\ProductTransaction;

use App\Http\Controllers\Controller;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;

class ProductTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productTransactions = ProductTransaction::all();

        return view('admin.product-transactions.index', compact('productTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductTransaction $productTransaction)
    {
        return view('admin.product-transactions.show', compact('productTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductTransaction $productTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductTransaction $productTransaction)
    {
        $productTransaction->update([
            'is_paid' => 1,
        ]);

        return redirect()->route('admin.product-transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductTransaction $productTransaction)
    {
        //
    }
}
