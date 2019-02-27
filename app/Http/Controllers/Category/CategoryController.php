<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;

class CategoryController extends ApiController
{
  
    public function index()
    {
        $categories=Category::all();
        return $this->showAll($categories);
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
               try{
        $newCategory = Category::create($request->all());
        return $this->showOne($newCategory,201);
               }catch(\Exception $e){
                return response()->json(['message'=> $e->getMessage()],422);
               }

    }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

      //  $category=Category::findOrFail($id);
        return $this->showOne($category);
       
    }


    public function update(Request $request, Category $category)
    {
  //  $category=Category::findOrFail($id);
    $category->fill($request->only([
        'name',
        'description',
    ]));
    if ($category->isClean()){
        return $this->errorResponse(['error'=>'You need  to specify  something for an update' , 'code'=>422],422);
    }
    else{
        $category->save();
        return $this->showOne($category);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try{
            $category->delete();
            return $this->showOne($category);
        }catch(\Exception $e){
            return response()->json(['message'=> $e->getMessage()],422);
        }
    }
}
