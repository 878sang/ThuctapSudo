<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'status',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ? asset('storage/images/' . $this->logo) : asset('assets/images/no-image.png');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }
}
