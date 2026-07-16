<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Models\Review;
use App\Repositories\Eloquent\BaseRepository;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function __construct(Review $review)
    {
        $this->model = $review;
    }

    public function getReviewsByProductId(int $productId, int $limit = 10)
    {
        return $this->model
            ->where('product_id', $productId)
            ->whereNull('parent_id')
            ->with([
                'user:id,name',
                'replies' => function ($query) {
                    $query->orderBy('created_at', 'asc')
                        ->with([
                            'user:id,name'
                        ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getRatingStatsByProductId(int $productId)
    {
        return $this->model
            ->where('product_id', $productId)
            ->whereNull('parent_id')
            ->selectRaw('rating, count(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating')
            ->toArray();
    }
}
