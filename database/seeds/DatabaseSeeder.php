<?php
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
//use illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
       User::truncate();
       Category::truncate();
       Product::truncate();
       Transaction::truncate();
       DB::table('category_product')->truncate();
       $usersQuantity=500;
       $categoriesQuantity=30;
       $productsQuantity=1000;
       $transactionsQuantity=1000;

    //   User:flushEventListeners();
     //  Category:flushEventListeners();
     //  Product:flushEventListeners();
     //  Transaction:flushEventListeners();
       

       factory(User::class,$usersQuantity)->create();
       factory(Category::class,$categoriesQuantity)->create();
       factory(Product::class,$productsQuantity)->create()->each(
           function($product){
               $categories=Category::all()->random(mt_rand(1,5))->pluck('id');
               $product->categories()->attach($categories);
           });
       
       factory(Transaction::class,$transactionsQuantity)->create();

    }
}
