<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerController extends ApiController
{
  /*  public function __construct(){
        parent::__construct();
        $this->middleware('scope:read-general' )->only('show'); 
        $this->middleware('can:view,seller' )->only('show'); 
    }
    */
     
    public function index()
    {
      //  $this->allowedAdminAction();
        $seller=Seller::has('products')->get();
        return $this->showAll($seller);
        //return response()->json(['data'=>$seller],200);
    }

  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
     //   $seller=Seller::has('products')->findOrFail($id);
        return $this->showOne($seller);
       // return response()->json(['data'=>$seller],200);
    }

   

  

}
