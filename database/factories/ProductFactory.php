<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'category_id' => Categories::pluck('id')->random(),
            'description' => $this->faker->paragraph(),
            'detail' => '<div>' . $this->faker->text(200) . '</div>',
            'avatar' => null,
            'images' => [],
            'status' => 1,
        ];
    }
}
