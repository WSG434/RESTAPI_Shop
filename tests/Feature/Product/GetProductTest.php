<?php

namespace Tests\Feature\Product;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ramsey\Collection\Collection;
use Tests\TestCase;

class GetProductTest extends TestCase
{

    private Product $product;
    private Product $draftProduct;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()
            ->for(User::factory())
            ->has(ProductReview::factory(5)->for(User::factory()), 'reviews')
            ->has(ProductImage::factory(3), 'images')
            ->createOne(['status' => ProductStatus::Published]);

        $this->draftProduct = Product::factory()
            ->createOne(['status' => ProductStatus::Draft]);
    }

    public function test_get_product(): void
    {
        $response = $this->get(route('products.show', ['product' => $this->product->id]));

        $response->assertOk();
        $response->assertJsonStructure([
           'id',
           'name',
           'description',
           'rating',
           'images',
           'price',
           'count',
           'reviews' => [
               '*' => ['id', 'userName', 'text', 'rating']
           ]
        ]);
        $response->assertJson([
           'id' => $this->product->id,
           'name' => $this->product->name,
           'description' => $this->product->description,
           'price' => $this->product->price,
           'count' => $this->product->count,
           'rating' => $this->getRating(),
           'images' => $this->getImagesArray(),
           'reviews' => $this->getReviews(),
        ]);
    }

    public function test_draft_product() :void
    {
        $response = $this->get(route('products.show', ['product'=>$this->draftProduct->id]));
        $response->assertNotFound();
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message'=>getMessage('product_not_found')]);
    }

    public function test_product_not_found() :void
    {
        $response = $this->get(route('products.show', ['product' => 0]));
        $response->assertNotFound();
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message'=>getMessage('route_not_found')]);
    }

    private function getRating(): int|float
    {
        return round($this->product->reviews->avg('rating'),1);
    }

    private function getImagesArray() :array
    {
        return $this->product->images->map(fn ($i) => $i->url)->toArray();
    }

    private function getReviews(): array
    {
        return $this->product->reviews->map(fn(ProductReview $review) => [
           'id' => $review->id,
           'userName' => $review->user->name,
           'text' => $review->text,
           'rating' => $review->rating,
        ])->toArray();
    }
}
