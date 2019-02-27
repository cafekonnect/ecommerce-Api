<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//User Routes
Route::resource('users', 'User\UserController');

//Category Routes
// returns all products for aspecific category url http://127.0.0.1:8000/api/categories/2/products
Route::resource('categories.products','Category\CategoryProductController',['only'=>['index',]]);
//shows lists of sellers for aspecific category url http://127.0.0.1:8000/api/categories/2/sellers
Route::resource('categories.sellers','Category\CategorySellerController',['only'=>['index',]]);
//shows lists of transactions for aspecific category
Route::resource('categories.transactions','Category\CategoryTransactionController',['only'=>['index',]]);
//shows lists of buyers for aspecific category url= http://127.0.0.1:8000/api/categories/2/buyers
 Route::resource('categories.buyers','Category\CategoryBuyerController',['only'=>['index',]]);




//Buyer Routes
Route::resource('buyers', 'Buyer\BuyerController');
////shows all transactions for aspecific buyer url : http://127.0.0.1:8000/api/buyers/10/transactions
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only'=>['index','show']]);
//shows lists of all products for aspecific buyer
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only'=>['index']]);
//Returns who sellers have sold through our site.Generally it shows who is selling.
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only'=>['index']]);
//Returns list of categories aspecific a buyer made apurchase url:http://127.0.0.1:8000/api/buyers/10/categories
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only'=>['index']]);




//Seller Routes
Route::resource('sellers', 'Seller\SellerController', ['only'=>['index','show']]);
//list all transactions for any specific seller 
Route::resource('sellers.transactions', 'Seller\SellerTransactionController', ['only'=>['index']]);
  //list of categories for any specific seller url http://127.0.0.1:8000/api/sellers/3/categories
  Route::resource('sellers.categories', 'Seller\SellerCategoryController', ['only'=>['index']]);
  //list of buyers for any specific seller  url http://127.0.0.1:8000/api/sellers/3/buyers
  Route::resource('sellers.buyers', 'Seller\SellerBuyerController', ['only'=>['index']]);
 //list of products for any specific seller url= http://127.0.0.1:8000/api/sellers/77/products
    Route::resource('sellers.products', 'Seller\SellerProductController', ['except'=>['create','show','edit']]);





//Route::put('categories/{id}', ['uses' => 'Category\CategoryController@update','as' => 'update']);
Route::resource('categories', 'Category\CategoryController', ['except'=>['create','edit']]);
//shows lists of transactions for aspecific category
//Route::resource('categories.transactions','Category\CategoryTransactionController',['only'=>['index',]]);
//shows lists of products for aspecific category
//Route::resource('categories.products','Category\CategoryProductController',['only'=>['index',]]);
//shows lists of sellers for aspecific category
//Route::resource('categories.sellers','Category\CategorySellerController',['only'=>['index',]]);
//shows lists of buyers for aspecific category url= http://127.0.0.1:8000/api/categories/2/buyer
//Route::resource('categories.buyers','Category\CategoryBuyerController',['only'=>['index',]]);


//Product Routes
Route::resource('products', 'Product\ProductController', ['only'=>['index','show']]);
//list of transactions for any specific product 
 Route::resource('products.transactions', 'Product\ProductTransactionController', ['only'=>['index']]);
//list of transactions for any specific product 
Route::resource('products.buyers', 'Product\ProductBuyerController', ['only'=>['index']]);
//list of categories for any specific product url http://127.0.0.1:8000/api/products/1/categories/5
Route::resource('products.categories', 'Product\ProductCategoryController', ['only'=>['index','update','destroy']]);

//creating of transactions for any specific product 
Route::resource('products.buyers.transactions', 'Product\ProductBuyerTransactionController', ['only'=>['store']]);



//Transaction Routes
Route::resource('transactions', 'Transaction\TransactionController', ['only'=>['index','show']]);
//Returns list of transactions for aparticular category url :http://127.0.0.1:8000/api/transactions/2/categories
Route::resource('transactions.categories',  'Transaction\TransactionCategoryController',['only'=>['index']]);
//Returns seller of a specific transactions  :http://127.0.0.1:8000/api/transactions/2/sellers
Route::resource('transactions.sellers',  'Transaction\TransactionSellerController',['only'=>['index']]);























