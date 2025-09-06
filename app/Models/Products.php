<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
        use HasFactory;


        protected $table = 'inventoryrestaurant';
        protected $fillable=[
            // 'product_id',
            // 'product_name',
            // 'price',
            // 'stock_quantity',
            // 'description',
            // 'p',
            // 'id_users'
        ];

// protected static function booted()
// {
//     static::creating(function ($product) {
//         $datePart = now()->format('Ymd');

//         // Get latest product with today's date prefix
//         $latest = static::where('product_id', 'like', $datePart . '%')
//                         ->orderBy('product_id', 'desc')
//                         ->first();

//         if ($latest) {
//             // Get the last sequence and increment it
//             $lastSequence = (int)substr($latest->product_id, -7);
//             $newSequence = str_pad($lastSequence + 1, 7, '0', STR_PAD_LEFT);
//         } else {
//             // First product of the day
//             $newSequence = '0000001';
//         }

//         $product->product_id = $datePart . $newSequence;
//         $product->p = bin2hex(random_bytes(16));
//     });
// }


    
//      public function user()
//     {
//         return $this->belongsTo(User::class, 'id_users');
//     }
//      public function imagedb()
//     {
//         return $this->hasMany(Imagedb::class, 'id_products');
//     }
}
