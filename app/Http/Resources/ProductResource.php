<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'stock' => $this->stock,
            'minimum_stock' => $this->minimum_stock,
            'status' => $this->status,
            'category_name' => $this->category->name,
            'thumbnail_url' => $this->thumbnail_url,
            'gallery_url' => $this->gallery_url,
            'created_at' => $this->created_at?->format('Y-m-d'),
        ];
    }
}

