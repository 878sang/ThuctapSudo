<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'avatar',
        'status',
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
