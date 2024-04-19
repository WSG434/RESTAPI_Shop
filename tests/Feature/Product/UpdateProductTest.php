<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
        $this->product = Product::factory()->createOne();
    }


    public function test_update_product(): void
    {
        $data = [
            'name' => 'New product name',
            'price' => '777'
        ];
        $response = $this->patch(route('products.update', ['product'=>$this->product->id]), $data);
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
            ]]);
        $response->assertJson([
            'name' => Arr::get($data,'name'),
            'price' => Arr::get($data,'price'),
        ]);
        $this->assertDatabaseHas(Product::class, [
            'id' => $this->product->id,
            'name' => Arr::get($data,'name'),
            'price' => Arr::get($data,'price'),
        ]);
    }
}
