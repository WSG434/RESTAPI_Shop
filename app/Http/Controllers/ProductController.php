<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\StoreReviewRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\MinifiedProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductReviewResource;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Services\Product\DTO\CreateProductDTO;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;
use App\Facades\Product as ProductFacade;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'review', 'destroy']);
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
        $this->middleware('product.draft')->only('show');
    }

    public function index()
    {
        return MinifiedProductResource::collection(
            ProductFacade::published()
        );
    }

    public function store(StoreProductRequest $request)
    {
        return new ProductResource(ProductFacade::store($request->DTO()));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function addReview(Product $product, StoreReviewRequest $request)
    {
        return new ProductReviewResource(
            ProductFacade::setProduct($product)->addReview($request)
        );
    }

    public function update(Product $product, UpdateProductRequest $request)
    {
        $product = ProductFacade::setProduct($product)->update($request);

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return responseOk();
    }
}
