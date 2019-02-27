<?php

namespace App\Models;

use App\Models\Product;

use App\Models\Category;
use App\Models\User;
use App\Models\Transaction;
use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends User
{use SoftDeletes;
  //  public $transformer=SellerTransformer::class;
    
  protected static function boot(){
    parent::boot();
    static::addGlobalScope(new SellerScope);
    }
  
  protected $dates= ['deleted_at'];
    
    protected $fillable=['image','description','name','quantity'];
    public function products(){
        return $this->hasMany(Product::class);
    }
   
}
