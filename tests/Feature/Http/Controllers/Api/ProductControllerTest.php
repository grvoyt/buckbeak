<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Events\ProductCreated;
use App\Events\ProductDeleted;
use App\Events\ProductUpdated;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index_good(): void
    {
        $user = User::factory()->create();
        Category::factory(10)->create();
        Product::factory(30)
            ->sequence(
                [
                    'category_id' => Category::query()->inRandomOrder()->value('id'),
                ]
            )
            ->create(['user_id' => $user->id]);
        $response = $this
            ->actingAs($user)
            ->get('/api/products');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'category' => [
                        'id','name'
                    ],
                    'created_at'
                ]
            ],
            'meta' => [
                "current_page",
                "from",
                "path",
                "per_page",
                "to"
            ]
        ]);

        $data = $response->collect('data');

        $product_ids = $data->pluck('id')->toArray();

        $count = $user
            ->products()
            ->whereIn('id',$product_ids)
            ->count();

        self::assertTrue(count($product_ids) === $count);
    }

    public function test_store_good(): void
    {
        Event::fake();
        $this->seed();
        $user = User::find(1);

        $data = [
            'name' => 'Iphone 12 mini',
            'description' => 'Little phone for big money',
            'category_id' => Category::query()->inRandomOrder()->value('id'),
            'country_id' => Country::query()->inRandomOrder()->value('id'),
            'status_id' => 3,
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/products', $data);

        Event::assertDispatched(ProductCreated::class);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'category' => [
                'id','name'
            ],
            'country' => [
                'id','name'
            ],
            'status' => [
                'id','name'
            ],
            'created_at',
            'updated_at'
        ]);

        $product_id = $response->json('id');

        $this->assertDatabaseHas(
            'products',
            [
                'id' => $product_id,
                'user_id' => $user->id,
            ]
        );
    }

    public function test_show_good()
    {
        $this->seed();
        $user = User::find(1);

        $product_id = $user->products()->inRandomOrder()->value('id');

        $response = $this->actingAs($user)
            ->getJson("/api/products/$product_id");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'category' => [
                'id','name'
            ],
            'country' => [
                'id','name'
            ],
            'status' => [
                'id','name'
            ],
            'created_at',
            'updated_at'
        ]);

        $not_user_product_id = Product::where('user_id', '!=',$user->id)->value('id');

        $response = $this->actingAs($user)
            ->getJson('/api/products/'.$not_user_product_id);

        $response->assertStatus(404);

        self::assertTrue(true);
    }

    public function test_update_good()
    {
        Event::fake();
        $this->seed();
        $user = User::find(1);

        $update_data = [
            'name' => 'new Name',
        ];

        $product_id = Product::where('user_id',$user->id)->value('id');

        $response = $this->actingAs($user)
            ->patchJson("/api/products/$product_id",$update_data);

        Event::assertDispatched(ProductUpdated::class);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'category' => [
                'id','name'
            ],
            'country' => [
                'id','name'
            ],
            'status' => [
                'id','name'
            ],
            'created_at',
            'updated_at'
        ]);

        $product_updated = Product::find($product_id);

        self::assertTrue(
            $product_updated->name === $update_data['name']
        );

        $not_user_product_id = Product::where('user_id', '!=',$user->id)->value('id');

        $response = $this->actingAs($user)
            ->patchJson("/api/products/$not_user_product_id",$update_data);

        $response->assertStatus(404);

        self::assertTrue(true);
    }

    public function test_delete_good()
    {
        $this->seed();
        $user = User::find(1);

        Event::fake();

        $product_id = Product::where('user_id',$user->id)->value('id');

        $response = $this->actingAs($user)
            ->deleteJson("/api/products/$product_id");

        Event::assertDispatched(ProductDeleted::class);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);

        $this->assertDatabaseMissing(
            'products',
            [
                'id' => $product_id,
            ]
        );

        $product_id = Product::where('user_id','!=',$user->id)->value('id');

        $response = $this->actingAs($user)
            ->deleteJson("/api/products/$product_id");

        $response->assertStatus(404);
    }

    public function test_dropdown_good()
    {
        $this->seed();
        $user = User::find(1);

        $response = $this->actingAs($user)
            ->getJson("/api/products/dropdown");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id','name'
                ]
            ],
            'meta' => [
                "current_page",
                "from",
                "path",
                "per_page",
                "to"
            ]
        ]);

        $data = $response->collect('data');

        $product_ids = $data->pluck('id')->toArray();

        $count = $user
            ->products()
            ->whereIn('id',$product_ids)
            ->count();

        self::assertTrue(count($product_ids) === $count);

        self::assertTrue(true);
    }
}
