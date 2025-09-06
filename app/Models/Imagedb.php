<?php

namespace App\Models;

use App\Models\Manager\InventoryRestaurant;
use App\Models\Manager\InventoryRetail;
use App\Models\Manager\InventorySalon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagedb extends Model
{
    //

    use HasFactory;
    protected $table = 'imagedb';

    // Fields that are mass assignable
    protected $fillable = [
        'image_path',
        'id_restaurant',
        'id_retail',
        'id_salon',
    ];
    public function inventoryrestaurant()
    {
        return $this->belongsTo(InventoryRestaurant::class, 'id_restaurant');
    }
public function retail()
{
    return $this->belongsTo(InventoryRetail::class, 'id_retail', 'id');
}

        public function inventorysalon()
    {
        return $this->belongsTo(InventorySalon::class, 'id_salon');
    }
}
