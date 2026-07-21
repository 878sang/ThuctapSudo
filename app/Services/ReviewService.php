<?php

namespace App\Services;

use App\Services\Interfaces\ReviewServiceInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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

        $avgRating = $totalReviews > 0 ? round(array_sum(array_map(function ($rating, $count) {
            return $rating * $count;
        }, array_keys($reviewStats), $reviewStats)) / $totalReviews, 1) : 0;

        $likedReviewIds = [];
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $likedReviewIds = $user->likedReviews()->pluck('review_id')->toArray();
        } else {
            $likedReviewIds = session()->get('liked_reviews', []);
        }

        return [
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'starPercentages' => $starPercentages,
            'avgRating' => $avgRating,
            'likedReviewIds' => $likedReviewIds,
        ];
    }
    public function toggleLike(int $id)
    {
        // Gọi qua Repository thay vì gọi Model trực tiếp
        $review = $this->reviewRepository->find($id);
        if (!$review) {
            return ['success' => false, 'message' => 'Đánh giá không tồn tại'];
        }

        $liked = false;

        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $hasLiked = $user->likedReviews()->where('review_id', $id)->exists();

            if ($hasLiked) {
                // Đã thích -> Bỏ thích
                $user->likedReviews()->detach($id);
                $likes = $this->reviewRepository->toggleLike($id, false);
                $liked = false;
            } else {
                // Chưa thích -> Thích
                $user->likedReviews()->attach($id);
                $likes = $this->reviewRepository->toggleLike($id, true);
                $liked = true;
            }
        } else {
            // Khách vãng lai -> Dùng Session làm fallback
            $sessionKey = 'liked_reviews';
            $likedReviews = session()->get($sessionKey, []);

            if (in_array($id, $likedReviews)) {
                $likes = $this->reviewRepository->toggleLike($id, false);
                $likedReviews = array_diff($likedReviews, [$id]);
                session()->put($sessionKey, $likedReviews);
                $liked = false;
            } else {
                $likes = $this->reviewRepository->toggleLike($id, true);
                $likedReviews[] = $id;
                session()->put($sessionKey, $likedReviews);
                $liked = true;
            }
        }

        return [
            'success' => true,
            'likes' => $likes,
            'liked' => $liked
        ];
    }
}
