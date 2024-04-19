<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    public function test_create_product(): void
    {
        $data = [
            'name' => fake()->sentence,
            'description' => fake()->text,
            'price' => 500,
            'count' => 12,
            'status' => 'published',
            'images' => [
                UploadedFile::fake()->image('image1.png', 100,100)->size(100),
                UploadedFile::fake()->image('image2.png', 100,100)->size(100)
            ]
        ];

        $response = $this->post(route('products.store'), $data);

        $response->assertCreated();
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
            ]]);
        $response->assertJson([
            'name' => Arr::get($data,'name'),
            'description' => Arr::get($data,'description'),
            'price' => Arr::get($data,'price'),
            'count' => Arr::get($data,'count'),
            'rating' => 0,
            'reviews' => [],
        ]);
        $this->assertCount(2, $response->json('images'));
        $this->assertDatabaseHas(Product::class, [
           'id' => $response->json('id'),
           'user_id' => $this->currentUserId(),
           'name' => Arr::get($data,'name'),
           'description' => Arr::get($data,'description'),
           'price' => Arr::get($data,'price'),
           'count' => Arr::get($data,'count'),
        ]);
    }

    public function test_create_product_failed_validation(): void
    {
        $data = [
          'description' => fake()->text,
          'price' => 500,
          'count' => 12
        ];

        $response = $this->post(route('products.store'), $data);
        $response->assertBadRequest();
        $response->assertJsonValidationErrors(['name', 'status']);
    }

}
