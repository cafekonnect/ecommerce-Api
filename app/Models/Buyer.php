<?php

namespace App\Models;
use App\Transformers\BuyerTransformer;
use App\Models\Transaction;
use App\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends User
{
    use SoftDeletes;

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new BuyerScope);
        }

   // public $transformer=BuyerTransformer::class;
    protected $dates= ['deleted_at'];
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}

