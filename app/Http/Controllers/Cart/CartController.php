<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Cart::where('user_id', auth()->id())->get();

        return view('front.carts', compact('items'));
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
        $existingCartItem = Cart::where('user_id', auth()->id())->where('product_id', $request->product_id)->first();

        if ($existingCartItem) {
            return redirect()->route('carts.index');
        }

        $cart = Cart::updateOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        $cart->save();

        return redirect()->route('carts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('carts.index');
    }
}
