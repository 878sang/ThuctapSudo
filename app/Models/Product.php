<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'detail',
        'avatar',
        'slug',
        'images',
        'status',
    ];
    protected $casts = [
        'images' => 'array',
    ];
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
