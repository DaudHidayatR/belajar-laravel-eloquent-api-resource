<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testResource(): void
    {
        $this->seed(CategorySeeder::class);
        $categories = Category::first();
        self::assertNotNull($categories);
        Log::info($categories->toJson());
        $this->get("/api/categories/$categories->id")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $categories->id,
                    'name' => $categories->name,
                    'created_at' => $categories->created_at->toJSON(),
                    'updated_at' => $categories->updated_at->toJSON(),
                ],
            ]);
    }

    public function testResourceCollection()
    {
        $this->seed(CategorySeeder::class);

        $all = Category::all();

        $this->get('/api/categories')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $all[0]->id,
                        'name' => $all[0]->name,
                        'created_at' => $all[0]->created_at->toJSON(),
                        'updated_at' => $all[0]->updated_at->toJSON(),
                    ],
                    [
                        'id' => $all[1]->id,
                        'name' => $all[1]->name,
                        'created_at' => $all[1]->created_at->toJSON(),
                        'updated_at' => $all[1]->updated_at->toJSON(),
                    ],
                ],
            ]);

    }

}
