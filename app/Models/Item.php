<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\BSON\ObjectId;

class Item extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['name', 'description', 'price', 'quantity', 'category_id'];

    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = new ObjectId($value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
