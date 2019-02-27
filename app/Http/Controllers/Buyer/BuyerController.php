<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
Use App\Models\Buyer;
use App\Http\Controllers\ApiController;
class BuyerController extends ApiController
{
     public function index()
    {
      // $this->allowedAdminAction();
         $buyers=Buyer::has('transactions')->get();
         return $this->showAll($buyers);
     
      // return response()->json(['data'=>$buyers],200);
    }
    public function show(Buyer $buyer)
    {
      //  $buy=Buyer::has('transactions')->findOrFail($buyer);
        return $this->showOne($buyer);
        // return response()->json(['data'=>$buy],200);
    }

  
}
