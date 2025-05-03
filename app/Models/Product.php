<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function rel_to_inventories()
    {
        return $this->hasMany(Inventory::class);
    }
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }

}
