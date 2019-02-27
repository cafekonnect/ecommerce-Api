<?php

namespace App\Http\Controllers\Transaction;


use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Controllers\ApiController;

class TransactionController extends ApiController
{
 /*   public function __construct(){
        parent::__construct();

        $this->middleware('scope:read-general' )->only('show');
        
        $this->middleware('can:view,transaction' )->only('show'); 
    }
    */
    public function index()
    {
       // $this->allowedAdminAction();
        $transactions=Transaction::all();
        return $this->showAll($transactions);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }


}
