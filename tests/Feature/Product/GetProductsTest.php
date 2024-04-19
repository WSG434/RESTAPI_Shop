<?php

namespace Tests\Feature\Product;

use App\Enums\ProductStatus;
use App\Facades\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetProductsTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp():void
    {
        parent::setUp();
        \App\Models\Product::factory(5)
            ->for(User::factory())
            ->create(['status'=>ProductStatus::Published]);
    }

    public function test_get_products(): void
    {
        $response = $this->get(route('products.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'price', 'rating'],
        ]);
    }
}
