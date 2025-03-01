<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempImage extends Model
{
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->name == "") {
            return asset('/uploads/no-image.jpg');
        }
        
        return asset('/uploads/temp/thumb/'.$this->name);
    }
}
