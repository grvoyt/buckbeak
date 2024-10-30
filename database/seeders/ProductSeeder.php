<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = Status::pluck('id')->toArray();
        Product::factory(100)
            ->sequence(
                [
                    'user_id' => 1,
                    'status_id' => $statuses[0],
                    'category_id' => Category::query()->inRandomOrder()->value('id'),
                    'country_id' => Country::query()->inRandomOrder()->value('id'),
                ],
                [
                    'user_id' => 1,
                    'status_id' => $statuses[1],
                    'category_id' => Category::query()->inRandomOrder()->value('id'),
                    'country_id' => Country::query()->inRandomOrder()->value('id'),
                ],
                [
                    'user_id' => 1,
                    'status_id' => $statuses[2],
                    'category_id' => Category::query()->inRandomOrder()->value('id'),
                    'country_id' => Country::query()->inRandomOrder()->value('id'),
                ],

                [
                    'user_id' => 2,
                    'status_id' => $statuses[0],
                    'category_id' => Category::query()->inRandomOrder()->value('id'),
                    'country_id' => Country::query()->inRandomOrder()->value('id'),
                ],
                [
                    'user_id' => 2,
                    'status_id' => $statuses[1],
                    'category_id' => Category::query()->inRandomOrder()->value('id'),
                    'country_id' => Country::query()->inRandomOrder()->value('id'),
                ],
                [
                    'user_id' => 2,
                    'status_id' => $statuses[2],
                    'category_id' => Category::query()->inRandomOrder()->value('id'),
                    'country_id' => Country::query()->inRandomOrder()->value('id'),
                ],
            )->create();


    }
}
