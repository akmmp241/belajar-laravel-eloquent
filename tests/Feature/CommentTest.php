<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class CommentTest extends TestCase
{
    public function testCreateComment()
    {
        $comment = new Comment();
        $comment->email = "akmal@gmail.com";
        $comment->title = "sample";
        $comment->comment = "sample comment";
        $comment->commentable_id = '1';
        $comment->commentable_type = 'product';
        $comment->save();

        self::assertNotNull($comment->id);
    }

    public function testDefaultAttributeValues()
    {
        $comment = new Comment();
        $comment->email = "akmal@gmail.com";
        $comment->commentable_id = '1';
        $comment->commentable_type = 'product';
        $comment->save();

        self::assertNotNull($comment->id);
        self::assertNotNull($comment->title);
        self::assertNotNull($comment->comment);
    }

    public function testCreate()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category"
        ];

        $json = json_encode($request);
        $request = json_decode($json, true);

        $category = new Category($request);
        $category->save();

        assertNotNull($category->id);
    }

    public function testCreateMethod()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category"
        ];

        $json = json_encode($request);
        $request = json_decode($json, true);

        $category = Category::create($request);
        assertNotNull($category->id);
    }

    public function testUpdateMass()
    {
        $this->seed(CategorySeeder::class);

        $request = [
            'name' => 'food updated',
            'description' => 'food category updated'
        ];

        $category = Category::find('food');
        $category->fill($request);
        $category->save();

        assertNotNull($category->id);
    }


}
