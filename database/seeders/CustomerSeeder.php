<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = new Customer();
        $customer->id = "AKMAL";
        $customer->name = "Akmal Muhammad";
        $customer->email = "akmal@gmail.com";
        $customer->save();
    }
}
