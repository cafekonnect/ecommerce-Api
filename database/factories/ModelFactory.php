<?php
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Faker\Generator as Faker;
use App\Models\Product;
use App\Models\Seller;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
       'password' => $password ? : $password = bcrypt('secret'), // secret
        'remember_token' => str_random(10),
        'verified'=>$verified=$faker->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
        'verification_token'=>$verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'admin' => $verified = $faker->randomElement([User::ADMIN_USER, User::REGULAR_USER])
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
       
    ];
});
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity'=>$faker->numberBetween(1,10),
        'status'=>$faker->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
        'image'=>$faker->randomElement(['pic6.jpg','pic7.jpg','pic8.jpg']),
        'seller_id'=>User::all()->random()->id,
       
    ];
});
$factory->define(Transaction::class, function (Faker $faker) {
    
    $seller=Seller::has('products')->get()->random();
    $buyer=User::all()->except($seller->id)->random();
    return [
     
       
        'quantity'=>$faker->numberBetween(1,5),
        'buyer_id'=>$buyer->id,
        'product_id'=>$seller->products->random()->id,
       
    ];
});
