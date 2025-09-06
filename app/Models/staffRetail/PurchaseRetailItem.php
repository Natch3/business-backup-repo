<?php

namespace App\Models\staffRetail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\staffRetail\PurchaseRetail;
use App\Models\Manager\InventoryRetail;

class PurchaseRetailItem extends Model
{
    use HasFactory;

    protected $table = 'purchase_retail_items';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'subtotal',
    ];

    // ✅ Belongs to a purchase
    public function purchase()
    {
        return $this->belongsTo(PurchaseRetail::class, 'purchase_id');
    }

    // ✅ If tied to products table
    public function product()
    {
        return $this->belongsTo(InventoryRetail::class, 'product_id');
    }
}