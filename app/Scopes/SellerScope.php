<?php
namespace App\Scopes;
Use Illuminate\Database\Eloquent\Model;
Use Illuminate\Database\Eloquent\Scope;
Use Illuminate\Database\Eloquent\Builder;
class SellerScope implements Scope
{

public function apply(Builder $builder,Model $model){
$builder->has('products');
}

}