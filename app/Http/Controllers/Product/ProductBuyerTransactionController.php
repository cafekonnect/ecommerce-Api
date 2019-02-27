<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Transformers\TransactionTransformer;
use App\Http\Controllers\ApiController;

class ProductBuyerTransactionController extends ApiController
{
    /*
     
    public function __construct(){
        parent::__construct();
        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-product')->only(['store']);
        $this->middleware('can:purchase,buyer' )->only('store');
    }
    
    */
   
    public function store(Request $request,Product $product,User $buyer)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        if($buyer->id==$product->seller_id){
            return $this->errorResponse('Thebuyer must be different from the seller',409);
        }
        if(!$buyer->isVerified()){
            return $this->errorResponse('The buyer must be a verified  user',409);
        }if(!$product->seller->isVerified()){
            return $this->errorResponse('The seller must be a verified  user',409);
        }if(!$product->isAvailable()){
            return $this->errorResponse('The product is not available',409);
        }
        if($product->quantity < $request->quantity){
            return $this->errorResponse('The product doesnt have enough pieces as per your request',409);
        }
        return DB::transaction(function ()use($request,$product,$buyer) {
           $product->quantity -= $request->quantity;
           $product->save();
           $transaction=Transaction::create([
            'quantity'=>$request->quantity,
            'buyer_id'=>$buyer->id,
            'product_id'=>$product->id,
                    ]);
               return $this->showOne($transaction,201);     
        });  

    }

 
}
