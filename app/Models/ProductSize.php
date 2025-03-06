<?php

namespace App\Models;

use App\Models\Size;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
