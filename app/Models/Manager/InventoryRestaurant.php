<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Imagedb;
use App\Models\OwnerAdmin\RegisterBranch;
class InventoryRestaurant extends Model
{
    //
    use HasFactory;


    protected $table = 'inventoryrestaurant';
    protected $fillable = [
        'id_users',
        'id_branch',
        'menu_id',
        'res',
        'menu_name',
        'menu_description',
        'menu_price',
        'menu_category'
    ];
protected static function booted()
{
    static::creating(function ($product) {
        $datePart = now()->format('Ymd');

        // Get latest product with today's date prefix
        $latest = static::where('menu_id', 'like', $datePart . '%')
                        ->orderBy('menu_id', 'desc')
                        ->first();

        if ($latest) {
            // Get the last sequence and increment it
            $lastSequence = (int)substr($latest->menu_id, -7);
            $newSequence = str_pad($lastSequence + 1, 7, '0', STR_PAD_LEFT);
        } else {
            // First product of the day
            $newSequence = '0000001';
        }

        $product->menu_id = $datePart . $newSequence;
        $product->res = bin2hex(random_bytes(16));
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
     public function imagedb()
    {
        return $this->hasMany(Imagedb::class, 'id_restaurant ');
    }
}
