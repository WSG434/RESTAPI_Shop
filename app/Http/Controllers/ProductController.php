<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->select(['id', 'name', 'price'])
            ->whereStatus(ProductStatus::Published)
            ->get();

        return $products->map(fn(Product $product) => [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'rating' => $product->rating()
        ]);
    }

    public function show(Product $product)
    {
        // TODO: перенести в middleware
        if ($product->status === ProductStatus::Draft){
               return response() -> json([
                   'message' => 'Product not found'
               ], 404);
        }

        return [
          'id' => $product->id,
          'name' => $product->name,
          'description' => $product->description,
          'rating' => $product->rating(),
          'images' => $product->images->map(fn(ProductImage $image) => $image->url),
          'price' => $product->price,
          'count' => $product->count,
          'reviews'=> $product->reviews->map(fn(ProductReview $review) => [
              'id' => $review->id,
              'userName' => $review->user->name,
              'text' => $review->text,
              'rating' => $review->rating,
          ]),
        ];

    }

}
