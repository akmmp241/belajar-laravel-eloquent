<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $image = new Image();
            $image->url = fake()->imageUrl;
            $image->imageable_id = "AKMAL";
            $image->imageable_type = 'customer';
            $image->save();
        }
        {
            $image = new Image();
            $image->url = fake()->imageUrl;
            $image->imageable_id = "1";
            $image->imageable_type = 'product';
            $image->save();
        }
    }
}
