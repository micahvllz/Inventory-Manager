<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['name', 'description'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
