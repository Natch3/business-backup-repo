<?php

namespace App\Http\Controllers\StaffRetail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Imagedb;
use App\Models\Manager\InventoryRetail;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\staffRetail\PurchaseRetail;
use App\Models\staffRetail\PurchaseRetailItem;
use Illuminate\Support\Facades\Validator;

class OrderStaffRetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();
        $search = $request->input('search');
        $category = $request->input('category'); // ✅ Get category filter

        // Start query with relation
        $query = InventoryRetail::with('images')
            ->where('id_users', $authUser->managers_id);

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                    ->orWhere('product_category', 'like', "%{$search}%");
            });
        }

        // ✅ Apply category filter if provided
        if ($category) {
            $query->where('product_category', $category);
        }

        // Paginate results
        $inventoryRetail = $query->paginate(1000);

        return inertia('staffpanel/staffretail/Order', [
            'inventoryRetail' => $inventoryRetail,
            'search' => $search,
            'category' => $category, // ✅ Pass category to frontend
        ]);
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
    $validated = Validator::make($request->all(), [
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'nullable|integer',
        'items.*.product_name' => 'required|string|max:255',
        'items.*.product_price' => 'required|numeric|min:0',
        'items.*.quantity' => 'required|integer|min:1',

        'subtotal' => 'required|numeric|min:0',
        'addBag' => 'boolean',
        'bagPrice' => 'numeric|min:0',
        'total_amount' => 'required|numeric|min:0',
        'cash_given' => 'required|numeric|min:0',   // ✅ must match Vue
        'change_amount' => 'nullable|numeric',
    ]);

    if ($validated->fails()) {
        return back()->withErrors($validated)->withInput();
    }

    try {
        $purchase = new PurchaseRetail();
        $purchase->id_users = Auth::id();
        $purchase->subtotal = $request->subtotal;
        $purchase->addBag = $request->addBag ?? false;
        $purchase->bagPrice = $request->bagPrice ?? 0;
        $purchase->total_amount = $request->total_amount;
        $purchase->cash_given = $request->cash_given;

        // ✅ Recalculate on backend (safer than trusting frontend)
        $purchase->change_amount = $request->cash_given - $request->total_amount;

        $purchase->save();

        foreach ($request->items as $item) {
            $purchaseItem = new PurchaseRetailItem();
            $purchaseItem->purchase_id = $purchase->id;
            $purchaseItem->product_id = $item['product_id'] ?? null;
            $purchaseItem->product_name = $item['product_name'];
            $purchaseItem->product_price = $item['product_price'];
            $purchaseItem->quantity = $item['quantity'];
            $purchaseItem->subtotal = $item['product_price'] * $item['quantity'];
            $purchaseItem->save();
        }

        return redirect()->back()->with('success', 'Order placed successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
    }
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
