<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::query()->insert([
            [
                'product_id' => 1,
                'customer_id' => 'AKMAL',
                'rating' => 5,
                'comment' => 'Bagus Banget'
            ],
            [
                'product_id' => '2',
                'customer_id' => 'AKMAL',
                'rating' => 3,
                'comment' => 'Lumayan'
            ]
        ]);
    }
}
