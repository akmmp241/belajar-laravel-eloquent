<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;

class CustomerTest extends TestCase
{
    public function testOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::query()->find("AKMAL");
        self::assertNotNull($customer);

        $wallet = $customer->wallet;

        self::assertEquals(1000000, $wallet->amount);
    }

    public function testOneToOneQuery()
    {
        $customer = new Customer();
        $customer->id = "AKMAL";
        $customer->name = "Akmal";
        $customer->email = "akmal@gmail.com";
        $customer->save();

        $wallet = new Wallet();
        $wallet->amount = 1000000;

        $customer->wallet()->save($wallet);

        self::assertNotNull($wallet->customer_id);
        self::assertEquals($customer->id, $wallet->customer_id);
    }

    public function testHasOneThrough()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::query()->find('AKMAL');
        self::assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;
        self::assertNotNull($virtualAccount);
        self::assertEquals("BCA", $virtualAccount->bank);
    }

    public function testManyToMany()
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class,]);

        $customer = Customer::query()->find('AKMAL');
        self::assertNotNull($customer);

        $product = Product::query()->find('1');
        self::assertNotNull($product);

        $customer->likesProducts()->attach($product->id);

        $products = $customer->likesProducts;
        self::assertCount(1, $products);
        self::assertEquals('1', $products[0]->id);

        $totalLikes = $product->likesProducts;
        self::assertCount(1, $totalLikes);
        self::assertEquals("AKMAL", $totalLikes[0]->id);
    }

    public function testRemoveManyToMany()
    {
        $this->testManyToMany();

        $customer = Customer::query()->find('AKMAL');

        $product = Product::query()->find('1');

        $customer->likesProducts()->detach($product->id);

        $products = $customer->likesProducts;
        self::assertNotNull($products);
        self::assertCount(0, $products);
    }

    public function testPivotAttribute()
    {
        $this->testManyToMany();

        $customer = Customer::query()->find('AKMAL');
        $products = $customer->likesProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    public function testPivotAttributeCondition()
    {
        $this->testManyToMany();

        $customer = Customer::query()->find('AKMAL');
        $products = $customer->likesProductsLastWeek;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    public function testPivotModel()
    {
        $this->testManyToMany();

        $customer = Customer::find('AKMAL');
        $products = $customer->likesProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot; // object like
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);

            self::assertNotNull($pivot->customer);
            self::assertNotNull($pivot->product);
        }
    }

    public function testOneToOnePolymorphic()
    {
        $this->seed([CustomerSeeder::class, ImageSeeder::class]);

        $customer = Customer::find('AKMAL');
        self::assertNotNull($customer);

        $image = $customer->image;
        self::assertNotNull($image);

        self::assertEquals('customer', $image->imageable_type);
        self::assertEquals($customer->id, $image->imageable_id);
    }

    public function testEagerLoading()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

        $customer = Customer::with(['image', 'wallet'])->find('AKMAL');
        self::assertNotNull($customer);
    }

    public function testEagerLoadingModel()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

        $customer = Customer::find('AKMAL');
        self::assertNotNull($customer);
    }
}
