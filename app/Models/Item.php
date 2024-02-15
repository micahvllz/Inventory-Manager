<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['name', 'description', 'price', 'quantity', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
