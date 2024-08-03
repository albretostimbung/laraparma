<?php

namespace App\Http\Controllers\ProductTransaction;

use Exception;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTrasaction\StoreProductTransactionRequest;
use Illuminate\Validation\ValidationException;

class ProductTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('owner')) {
            $productTransactions = ProductTransaction::latest()->get();
        } else {
            $productTransactions = ProductTransaction::where('user_id', auth()->id())->latest()->get();
        }

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
    public function store(StoreProductTransactionRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $subTotalCents = 0;
                $deliveryFeeCents = 10000 * 100;

                $cartItems = Cart::where('user_id', auth()->id())->get();

                foreach ($cartItems as $cartItem) {
                    $subTotalCents += $cartItem->product->price * 100;
                }

                $taxCents = (int) round(11 * $subTotalCents / 100);
                $insuranceCents = (int) round(23 * $subTotalCents / 100);
                $grandTotalCents = $subTotalCents + $taxCents + $insuranceCents + $deliveryFeeCents;

                $grandTotal = $grandTotalCents / 100;

                if (!$request->hasFile('proof')) {
                    $productTransaction = ProductTransaction::create($request->validated() + [
                        'user_id' => auth()->id(),
                        'total_amount' => $grandTotal,
                        'is_paid' => false,
                    ]);

                    return;
                }

                $proofPath = $request->file('proof')->store('payment_proofs', 'public');
                $validated = array_merge($request->validated(), [
                    'proof' => $proofPath
                ]);

                $productTransaction = ProductTransaction::create($validated + [
                    'user_id' => auth()->id(),
                    'total_amount' => $grandTotal,
                    'is_paid' => false,
                ]);

                foreach ($cartItems as $item) {
                    TransactionDetail::create([
                        'product_transaction_id' => $productTransaction->id,
                        'product_id' => $item->product_id,
                        'price' => $item->product->price
                    ]);

                    $item->delete();
                }
            });

            return redirect()->route('front.success-checkout');
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
        }
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

        return redirect()->route('product-transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductTransaction $productTransaction)
    {
        //
    }
}
