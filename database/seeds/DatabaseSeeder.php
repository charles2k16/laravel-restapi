<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS = 0');

    User::truncate();
    Category::truncate();
    Product::truncate();
    Transaction::truncate();
    DB::table('category_product')->truncate();

    $usersQuantity = 100;
    $categoriesQuantity = 20;
    $productsQuantity = 150;
    $transactionsQuantity = 50;

    factory(User::class, $usersQuantity)->create();
    factory(Category::class, $categoriesQuantity)->create();
    factory(Product::class, $productsQuantity)->create()->each(
      function ($product) {
        $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
        $product->categories()->attach($categories);
      }
    );
    factory(Transaction::class, $transactionsQuantity)->create();
  }
}
