<?php

namespace App\Providers;
use Carbon\Carbon;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use  App\Policies\UserPolicy;
use  App\Policies\BuyerPolicy;
use Laravel\Passport\Passport;
use  App\Policies\ProductPolicy;
use  App\Policies\SellerPolicy;
use  App\Policies\TransactionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       
  //  Buyer::class=>BuyerPolicy::class
  //  User::class=>UserPolicy::class
  //  Seller::class=>SellerPolicy::class
 // Product::class=>ProductPolicy::class
//  Transaction::class=>TransactionPolicy::class

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
/*
        Gate::define('admin-action',function($user){
            return $user->isAdmin();
        });

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();
        Passport::tokensCan([
'purchase-product'=>'Creates anew transaction',
'manage-products'=>'Perform CRUD',
'manage-account'=>'Read acc data,id,name,email,if verified.Modify
                    account data(email,password) Cannot delete your account',
'read-general'=>'read general info like purchasing categories,purchased products,selling products etc'



        ]);
        */
    }
    
}
