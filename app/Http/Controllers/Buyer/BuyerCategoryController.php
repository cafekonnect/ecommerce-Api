<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerCategoryController extends ApiController
    {
        /*
            public function __construct(){
                parent::__construct();
                $this->middleware('scope:read-general' )->only('index'); 
                $this->middleware('can:view,buyer' )->only('index');  
            }
              */  public function index(Buyer $buyer)
                {
                    $sellers=$buyer->transactions()->with('product.categories')
                    ->get()
                    ->pluck('product.categories')
                    ->collapse()
                    ->unique('id')
                    ->values();

                /* ->unique('id')
                    ->values();*/
                return $this->showAll($sellers);
                }


    
    }
