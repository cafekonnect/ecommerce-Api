<?php



    namespace App\Http\Controllers\Product;
    use App\Models\Product;
    use Illuminate\Http\Request;
    use App\Transformers\ProductTransformer;
    use App\Http\Controllers\ApiController;
    class ProductController extends ApiController

    {
       /* public function __construct(){
            $this->middleware('client.credentials:' )->only(['index','show']);
            $this->middleware('transform.input:' . ProductTransformer::class)->only(['store', 'update']);
        }
        */

        public function index()
        {
            $products=Product::all();
            return $this->showAll($products);
            
        }

        public function store(Request $request)
        {
            $validation=Validator::make($request->all(),[
                'name'=>'required',
                'description'=>'required',  
                
            ]);
           if(
               $validation->fails()){
                return response()->json(['message'=>$validation->messages()->all()],200);
               }
               else{
            
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'units' => $request->units,
                'price' => $request->price,
                'image' => $request->image
            ]);

            return response()->json([
                'status' => (bool) $product,
                'data'   => $product,
                'message' => $product ? 'Product Created!' : 'Error Creating Product'
            ]);
        }
    }

        public function show(Product $product)
        {
            return $this->showOne($product);
        }

        public function uploadFile(Request $request)
        {
            if($request->hasFile('image')){
                $name = time()."_".$request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('images'), $name);
            }
            return response()->json(asset("images/$name"),201);
        }

        public function update(Request $request, Product $product)
        {
            $status = $product->update(
                $request->only(['name', 'description', 'units', 'price', 'image'])
            );

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Product Updated!' : 'Error Updating Product'
            ]);
        }

        public function updateUnits(Request $request, Product $product)
        {
            $product->units = $product->units + $request->get('units');
            $status = $product->save();

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Units Added!' : 'Error Adding Product Units'
            ]);
        }

        public function destroy(Product $product)
        {
            $status = $product->delete();

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Product Deleted!' : 'Error Deleting Product'
            ]);
        }
    }