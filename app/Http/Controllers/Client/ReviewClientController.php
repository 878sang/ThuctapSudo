<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ReviewServiceInterface;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewClientController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewServiceInterface $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function storeReview(StoreReviewRequest $request, $productId)
    {
        $validated = $request->validated();
        $validated['product_id'] = $productId;
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }
        $this->reviewService->create($validated, $request);
        return redirect()->route('products.detailClient', $productId)->with('success', 'Đánh giá thành công');
    }
    public function updateReview(UpdateReviewRequest $request, $id)
    {
        $validated = $request->validated();
        $review = $this->reviewService->find($id);
        if (!Auth::check() || !$review || $review->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa đánh giá này.');
        }
        $this->reviewService->update($validated, $request, $id);

        return redirect()->back()->with('success', 'Cập nhật đánh giá thành công!');
    }
}
