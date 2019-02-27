<?php

namespace App\Http\Controllers\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionSellerController extends ApiController
{
  /*  public function __construct(){
        parent::__construct();
        $this->middleware('can:view,transaction' )->only('index');
        $this->middleware('scope:read-general' )->only('index'); 
    }
    */
    public function index(Transaction $transaction)
    {
        $seller=$transaction->product->seller;
        return $this->showOne($seller);
       // return([ 'message'=>'Ihave your message']);
    }

  
  
}
