<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // $table->renameColumn('avatar', 'thumbnail');
            // $table->renameColumn('images', 'gallery');
            // $table->string('sku')->unique()->after('id');
            // $table->string('brand')->nullable()->after('category_id');
            // $table->text('short_description')->nullable()->after('brand');
            // $table->decimal('cost_price', 15, 2)->default(0)->after('short_description');
            // $table->decimal('price', 15, 2)->default(0)->after('cost_price');
            // $table->decimal('sale_price', 15, 2)->nullable()->after('price');
            // $table->integer('stock')->default(0)->after('sale_price');
            // $table->integer('minimum_stock')->default(0)->after('stock');
            // $table->decimal('weight', 8, 2)->nullable()->after('minimum_stock');
            // $table->decimal('length', 8, 2)->nullable()->after('weight');
            // $table->decimal('width', 8, 2)->nullable()->after('length');
            // $table->decimal('height', 8, 2)->nullable()->after('width');
            // $table->boolean('featured')->default(false)->after('height');
            // $table->string('seo_title')->nullable()->after('status');
            // $table->text('seo_description')->nullable()->after('seo_title');
            // $table->string('seo_keyword')->nullable()->after('seo_description');
            // $table->timestamp('published_at')->nullable()->after('seo_keyword');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('thumbnail', 'avatar');
            $table->renameColumn('gallery', 'images');
            $table->dropColumn([
                'sku',
                'brand',
                'short_description',
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
                'published_at'
            ]);
        });
    }
};
