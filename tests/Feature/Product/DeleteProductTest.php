<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
        $this->product = Product::factory()->createOne();
    }

    public function test_delete_product(): void
    {
        $response = $this->delete(route('products.destroy', ['product' => $this->product->id]));
        $response->assertOk();
        $this->assertDatabaseMissing(Product::class, [
           'id' => $this->product->id,
        ]);
    }
}
