<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class CategoryTest extends TestCase
{
    public function testInsert()
    {
        $category = new Category();

        $category->id = "GADGET";
        $category->name = "Gadget";
        $category->description = "Gadet";
        $result = $category->save();

        self::assertTrue($result);
    }

    public function testInsertManyCategory()
    {
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Name $i",
                "is_active" => true
            ];
        }

//        $result = Category::query()->insert($categories);
        $result = Category::insert($categories);
        assertTrue($result);

        $total = Category::query()->count();
        self::assertEquals(10, $total);
    }

    public function testFind()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");

        self::assertNotNull($category);
        assertEquals("FOOD", $category->id);
        assertEquals("Food", $category->name);
        assertEquals("Food Category", $category->description);
    }

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);


        $category = Category::find("FOOD");
        $category->name = "Food update";

        $result = $category->update();

        assertTrue($result);
    }

    public function testSelect()
    {
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->id = "ID $i";
            $category->name = "Name $i";
            $category->is_active = true;
            $category->save();
        }

        $categories = Category::query()->whereNull("description")->get();
        assertEquals(5, $categories->count());
        $categories->each(function ($category) {
            self::assertNull($category->description);

            $category->description = "Updated";
            $category->update();
        });
    }

    public function testUpdateMany()
    {
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Name $i",
                "is_active" => true
            ];
        }

        $result = Category::insert($categories);
        assertTrue($result);

        Category::whereNull("description")->update([
            "description" => "updated"
        ]);
        $total = Category::where("description", "=", "updated")->count();
        assertEquals(10, $total);
    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");
        $result = $category->delete();
        assertTrue($result);

        $categories = Category::count();
        self::assertEquals(0, $categories);
    }

    public function testDeleteMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Name $i",
                "is_active" => true
            ];
        }

        $result = Category::insert($categories);
        assertTrue($result);

        $total = Category::count();
        assertEquals(10, $total);

        Category::whereNull("description")->delete();

        $total = Category::count();
        assertEquals(0, $total);

    }

    public function testRemoveGlobalScope()
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = false;
        $category->save();

        $category = Category::query()->find("FOOD");
        self::assertNull($category);

        $category = Category::query()->withoutGlobalScopes([IsActiveScope::class])->find("FOOD");
        self::assertNotNull($category);
    }

    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find("FOOD");

        $products = $category->products;

        self::assertNotNull($products);
        self::assertCount(2, $products);
    }

    public function testOneToManyQuery()
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = 'Food Category';
        $category->description = 'Food description';
        $category->is_active = true;
        $category->save();

        self::assertNotNull($category);

        $product = new Product();
        $product->id = '1';
        $product->name = 'Food Product';
        $product->description = "Food description";

        $category->products()->save($product);

        self::assertNotNull($product->category_id);
        self::assertEquals($category->id, $product->category_id);
    }

    public function testRelationshipQuery()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find("FOOD");
        $products = $category->products;
        self::assertCount(2, $products);

        $outOfStockProducts = $category->products()->where('stock', '<=', 0)->get();
        assertCount(2, $outOfStockProducts);
    }

    public function testHasManyThrough()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, CustomerSeeder::class, ReviewSeeder::class]);

        $category = Category::query()->find('FOOD');
        self::assertNotNull($category);

        $reviews = $category->reviews;
        self::assertNotNull($reviews);

    }

    public function testQueryingRelation()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('FOOD');
        $products = $category->products()->where('price', '=', 200)->get();

        self::assertNotNull($products);
        self::assertCount(1, $products);
        self::assertEquals(200, $products[0]->price);
        self::assertEquals(2, $products[0]->id);
    }

    public function testAggregatingRelation()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('FOOD');
        $total = $category->products()->count();

        assertEquals(2, $total);


        $total = $category->products()->where('price', '=', 200)->count();

        self::assertEquals(1, $total);
    }
}
