<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryProductController extends ApiController
{

     
/*    public function __construct(){
        $this->middleware('client.credentials:' )->only(['index']);
     
    }
    */
    public function index(Category $category)
    {
        $products=$category->products;
        return $this->showAll($products);
    }

   


}
