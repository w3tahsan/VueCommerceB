<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model

{
    use SoftDeletes;

    protected $guarded = ['id'];

    function rel_to_subcategory(){
        return $this->hasMany(Subcategory::class, 'category_id', 'id');
    }
}
