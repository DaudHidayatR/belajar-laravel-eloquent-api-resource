<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testProduct(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $products = Product::first();

        $this->get("/api/products/$products->id")->assertStatus(200)
            ->assertJson([
            'value' => [
                'name' => $products->name,
                'category' => [
                    'id' => $products->category->id,
                    'name' => $products->category->name
                ],
                'price' => $products->price,
                'created_at' => $products->created_at->toJSON(),
                'updated_at' => $products->updated_at->toJSON()
            ]
        ]);

    }
}
