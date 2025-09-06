<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Imagedb;
use App\Models\OwnerAdmin\RegisterBranch;

class InventoryRetail extends Model
{
    //
    use HasFactory;


    protected $table = 'inventoryretail';
    protected $fillable = [
        'id_users',
        'id_branch',
        'product_id',
        'ret',
        'product_name',
        'product_description',
        'product_category',
        'product_price',
        'product_sku',
        'product_unit',
        'product_stock_quantity'
    ];
    protected static function booted()
    {
        static::creating(function ($product) {
            $datePart = now()->format('Ymd');

            // Get latest product with today's date prefix
            $latest = static::where('product_id', 'like', $datePart . '%')
                ->orderBy('product_id', 'desc')
                ->first();

            if ($latest) {
                // Get the last sequence and increment it
                $lastSequence = (int)substr($latest->product_id, -7);
                $newSequence = str_pad($lastSequence + 1, 7, '0', STR_PAD_LEFT);
            } else {
                // First product of the day
                $newSequence = '0000001';
            }

            $product->product_id = $datePart . $newSequence;
            $product->ret = bin2hex(random_bytes(16));
        });
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
    public function branches()
    {
        return $this->belongsTo(RegisterBranch::class, 'id_branch');
    }
public function images()
{
    return $this->hasMany(Imagedb::class, 'id_retail', 'id');
}

}
