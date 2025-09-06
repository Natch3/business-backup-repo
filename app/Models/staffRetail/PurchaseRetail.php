<?php

namespace App\Models\staffRetail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\staffRetail\PurchaseRetailItem;
class PurchaseRetail extends Model
{
    use HasFactory;

    protected $table = 'purchase_retail';

    protected $fillable = [
        'id_users',
        'subtotal',
        'addBag',
        'bagPrice',
        'total_amount',
        'cash_given',
        'change_amount',
    ];

    // ✅ A purchase has many items
    public function items()
    {
        return $this->hasMany(PurchaseRetailItem::class, 'purchase_id');
    }

    // ✅ If linked to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
