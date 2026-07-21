<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

    protected $fillable = [
        'parent_id',
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

    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id');
    }
    public function activeChildren()
    {
        return $this->hasMany(Categories::class, 'parent_id')
            ->active();
    }
    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }
    public function hasChildren(): bool
    {
        return $this->activeChildren->isNotEmpty();
    }
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function getAvatarUrlAttribute(): string
    {
        return asset('storage/images/' . $this->avatar);
    }
}
