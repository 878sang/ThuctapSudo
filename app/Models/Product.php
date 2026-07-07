<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_DRAFT = 'draft';
    const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'name',
        'sku',
        'brand',
        'cost_price',
        'price',
        'sale_price',
        'stock',
        'minimum_stock',
        'weight',
        'length',
        'width',
        'height',
        'featured',
        'seo_title',
        'seo_description',
        'seo_keyword',
        'published_at',
        'category_id',
        'description',
        'detail',
        'thumbnail',
        'slug',
        'gallery',
        'status',
    ];
    protected $casts = [
        'gallery' => 'array',
        'published_at' => 'datetime',
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
    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
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

    public function getThumbnailUrlAttribute(): string
    {
        return asset('storage/images/' . $this->thumbnail);
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (!$this->gallery || !is_array($this->gallery)) {
            return [];
        }
        return array_map(fn($img) => asset('storage/products/' . $img), $this->gallery);
    }
}
