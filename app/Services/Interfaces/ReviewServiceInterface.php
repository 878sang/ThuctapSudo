<?php

namespace App\Services\Interfaces;

interface ReviewServiceInterface extends BaseServiceInterface
{
    public function getReviewsByProductId(int $productId, int $limit = 10);
    public function getReviewDetailsByProductId(int $productId);
    public function toggleLike(int $id);
}
