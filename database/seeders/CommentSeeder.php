<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->creatCommentForProduct();
        $this->createCommentForVoucher();
    }

    private function creatCommentForProduct(): void
    {
        $product = Product::find('1');

        $comment = new Comment();
        $comment->email = 'akmal@gmail.com';
        $comment->title = 'sample title';
        $comment->commentable_id = $product->id;
        $comment->commentable_type = 'product';
        $comment->save();
    }

    private function createCommentForVoucher(): void
    {
        $voucher = Voucher::first();

        $comment = new Comment();
        $comment->email = 'akmal@gmail.com';
        $comment->title = 'sample title';
        $comment->commentable_id = $voucher->id;
        $comment->commentable_type = 'voucher';
        $comment->save();
    }
}
