<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Transformers\ProductTransfomer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
   /*
    public function __construct(){
        parent::__construct();
        $this->middleware('can:view,seller' )->only('index');
        $this->middleware('can:sale,seller' )->only('store'); 
        $this->middleware('can:edit-product,seller' )->only('update');
        $this->middleware('can:delete-product,seller' )->only('destroy'); 
        $this->middleware('transform.input' . ProductTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-products')->except('index');
    
    }
    */
    public function index(Seller $seller)
    {
       // if(request()->user()->tokenCan('read-general') || request()->user()->tokenCan('manage-products')){

            $products=$seller->products;
            return $this->showAll($products);
       // }
       // throw new AuthorizationException('invalid scopes');
    }

    public function store(Request $request, User $seller)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->all();
       // dd($data);
     //  $name = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
       // $data['quantity']=$request->quantity;
        $data['status']=Product::UNAVAILABLE_PRODUCT;
        $data['image']='file.jpg';
        
        //$request->file('image')->move(public_path('images'), $name);
        $data['seller_id']=$seller->id;
        $data['quantity'] = $request['quantity'];
        $product =Product::create($data);
       

        return $this->showOne($product);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller,Product $product)
    {
        $validator = Validator::make($request->all(), [
           
            'image' => 'image',
            'quantity' => 'integer|min:1',
            'status' => 'in:' .Product::AVAILABLE_PRODUCT . '.' .Product::UNAVAILABLE_PRODUCT,
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $this->checkSeller($seller,$product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity'
        ]));
        if($request->has('status')){
            $product->status=$request->status;
                 if($product->isAvailable() && $product->categories()->count==0){
                  
                 return $this->errorResponse(['An active product must have atleast one category','code'=>422],422);
                }
        
        }
      /*  if ($request->hasFile('image')){
            Storage::delete('$product->image');
            $product->image=$request->image->store('');
        }
        */
        if($product->isClean()){
            return $this->errorResponse('You need to specify a different value for an update,422');
        }
       
        $product->save();

        return $this->showOne($product);
    }

    /**   
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {$this->checkSeller($seller,$product);
        
        $product->delete();
        Storage::delete($product->image);
        return  $this->showOne($product);

        
    }
    protected function checkSeller(Seller $seller,Product $product){
        if ($seller->id !=$product->seller_id){
        throw new HttpException(422,'The specified seller isnt the actual seller of this product');         
            }
}
}
