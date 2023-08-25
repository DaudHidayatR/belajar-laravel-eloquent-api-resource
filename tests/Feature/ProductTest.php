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
    public function testCollectionWrap()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);


        $response =$this->get('/api/products')
            ->assertStatus(200);
        $names = $response->json('data.*.name');
        for ($i = 1; $i <= 10; $i++) {
            self::assertContains("Product $i of Food", $names);

        }
        for ($i = 1; $i <= 10; $i++) {
            self::assertContains("Product $i of Drink", $names);
        }
    }

    public function testProductsPaging()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $response = $this->get('api/products-paging')
            ->assertStatus(200);
        self::assertNotNull('links');
        self::assertNotNull('meta');
        self::assertNotNull('data');
    }

}
