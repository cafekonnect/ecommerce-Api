<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{
    
   /*  
    public function __construct(){
        $this->middleware('client.credentials:' )->only(['index']);
        $this->middleware('auth:api' )->except(['index']);
        $this->middleware('can:add-category,product' )->only(['update']);
        $this->middleware('can:delete-category,product' )->only(['destroy']);
        $this->middleware('scope:manage-products')->except('index');
    
    }
     */
    public function index(Product $product)
    {
        $categories=$product->categories;
        return $this->showAll($categories);
    }
 

   
    public function update(Request $request, Product $product,Category $category)
    {
        $product->categories()->syncWithoutDetaching(([$category->id]));
        return $this->showAll($product->categories);
    }

   
    public function destroy(Product $product,Category $category)

    {
        if(!$product->categories()->find($category->id)){
            return $this->errorResponse('The specified category is not acategory for this product',404);
           
    }
    $product->categories()->detach($category->id);
    return $this->showAll($product->categories);
}
}
