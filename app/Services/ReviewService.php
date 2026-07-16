<?php

namespace App\Services;

use App\Services\Interfaces\ReviewServiceInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;

class ReviewService extends BaseService implements ReviewServiceInterface
{
    protected $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        parent::__construct($reviewRepository);
        $this->reviewRepository = $reviewRepository;
    }

    public function getReviewsByProductId(int $productId, int $limit = 10)
    {
        return $this->reviewRepository->getReviewsByProductId($productId, $limit);
    }

    public function getReviewDetailsByProductId(int $productId)
    {
        $reviews = $this->getReviewsByProductId($productId);
        $reviewStats = $this->reviewRepository->getRatingStatsByProductId($productId);
        
        $totalReviews = array_sum($reviewStats);
        $starPercentages = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviewStats[$i] ?? 0;
            $starPercentages[$i] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
        }
        
        $avgRating = $totalReviews > 0 ? round(array_sum(array_map(function($rating, $count) {
            return $rating * $count;
        }, array_keys($reviewStats), $reviewStats)) / $totalReviews, 1) : 0;

        return [
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'starPercentages' => $starPercentages,
            'avgRating' => $avgRating,
        ];
    }
}
