<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = ['image_url'];

    protected $fillable = [
        'title',
        'price' ,
        'compare_price',
        'description',
        'short_description', 
        'category_id',
        'brand_id',
        'qty',
        'sku',
        'barcode',
        'status',
        'is_featured',
        'image'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image == "") {
            return asset('/uploads/no-image.jpg');
        }
        
        return asset('/uploads/products/small/'.$this->image);
    }
}
