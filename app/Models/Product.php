<?php
namespace App\Models;
    use App\Models\Seller;
    use App\Models\Category;
    use App\Models\Transaction;
    use Illuminate\Database\Eloquent\Model;
    use App\Transformers\ProductTransformer;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Product extends Model
    {
        use SoftDeletes;

       // public $transformer=ProductTransformer::class;
        
        const AVAILABLE_PRODUCT='available';
        const UNAVAILABLE_PRODUCT='unavailable';
        protected $fillable = [
            'name', 'description','image' ,'seller_id','quantity','status'
        ];
        
        protected $hidden=[
                 'pivot',
             ];
        public function isAvailable(){
            return $this->status==Product::AVAILABLE_PRODUCT;
        }
        public function transactions(){
            return $this->hasMany(Transaction::class);
        }
        public function categories(){
            return $this->belongsToMany(Category::class);
        }
        
        public function seller(){
            return $this->belongsTo(Seller::class);
        }

    }