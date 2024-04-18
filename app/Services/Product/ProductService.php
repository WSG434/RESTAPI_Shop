<?php

namespace App\Services\Product;

use App\Enums\ProductStatus;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\StoreReviewRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    private Product $product;

    public function published(array $fields = ['id', 'name', 'price']) : Collection
    {
        return Product::query()
            ->select(['id', 'name', 'price'])
            ->whereStatus(ProductStatus::Published)
            ->get();
    }

    public function store(StoreProductRequest $request): Product
    {
        /** @var Product $product */
        $product = auth()->user()->products()->create([
            'name' => $request->str('name'),
            'description' => $request->str('description'),
            'price' => $request->integer('price'),
            'count' => $request->integer('count'),
            'status' => $request->enum('status', ProductStatus::class),
        ]);

        foreach ($request->file('images') as $item){
            $path = $item->storePublicly('images');
            $product->images()->create([
                'url' => config('app.url') . Storage::url($path)
            ]);
        }

        return $product;
    }

    public function update(UpdateProductRequest $request): Product
    {
        if ($request->method() === 'PUT'){
            $this->product->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'count' => $request->input('count'),
                'status' => $request->enum('status', ProductStatus::class),
            ]);
        } else {
            $data = [];

            // TODO: Испольльзовать DTO

            if ($request->has('name')){
                $data['name'] = $request->input('name');
            }

            if ($request->has('description')){
                $data['description'] = $request->input('description');
            }

            if ($request->has('price')){
                $data['price'] = $request->input('price');
            }

            if ($request->has('count')){
                $data['count'] = $request->input('count');
            }

            if ($request->has('status')){
                $data['status'] = $request->input('status');
            }

            $this->product->update($data);
        }

        return $this->product;
    }


    public function addReview(StoreReviewRequest $request) : ProductReview
    {
        return $this->product->reviews()->create([
            'user_id' => auth()->id(),
            'text' => $request->str('text'),
            'rating' => $request->integer('rating')
        ]);
    }

    public function setProduct(Product $product): ProductService
    {
        $this->product = $product;
        return $this;
    }

}
