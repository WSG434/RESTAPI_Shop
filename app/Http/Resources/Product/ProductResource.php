<?php

namespace App\Http\Resources\Product;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin \App\Models\Product
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'rating' => $this->rating(),
            'images' => $this->imageList(),
            'price' => $this->price,
            'count' => $this->count,
            'reviews' => ProductReviewResource::collection($this->reviews)
        ];
    }
}
