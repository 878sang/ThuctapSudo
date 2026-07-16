<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CategoryServiceInterface;

class CategoriesClientController extends Controller
{
    protected CategoryServiceInterface $categoryService;
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function showClient()
    {
        $categories = $this->categoryService->getActiveWithChildren();
        return view('client.categogies.show', compact('categories'));
    }
}
