<?php

namespace App\Repositories\Interfaces;

interface ReviewRepositoryInterface extends BaseRepositoryInterface
{
    public function getReviewsByProductId(int $productId, int $limit = 10);
    public function getRatingStatsByProductId(int $productId);
    public function toggleLike(int $id, bool $increment);
}
