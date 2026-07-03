<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

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


    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Check if the product is active.
     */
    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function scopeOrderAsc($query)
    {
        return $query->orderBy('name', 'asc');
    }

    public function scopeOrderDesc($query)
    {
        return $query->orderBy('name', 'desc');
    }
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }


    public function scopeOfCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }


    public function scopeFilterStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeFilterTrash($query, $action)
    {
        if ($action === 'trash') {
            return $action === 'trash'
                ? $query->onlyTrashed()
                : $query;
        }
    }

    public function getAvatarUrlAttribute(): string
    {
        return asset('storage/images/' . $this->avatar);
    }

    public function getImageUrlsAttribute(): array
    {
        if (!$this->images || !is_array($this->images)) {
            return [];
        }
        return array_map(fn($img) => asset('storage/products/' . $img), $this->images);
    }
}
