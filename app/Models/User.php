<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public $transformer=UserTransformer::class;
    const VERIFIED_USER= '1';
    const UNVERIFIED_USER= '0';
    
    protected $dates= ['deleted_at'];
    protected $table='users';

    const ADMIN_USER= 'true';
    const REGULAR_USER='false';
   
    protected $fillable = [
        'name', 'email', 'password','verified','verification_token','admin'
    ];

    protected $hidden = [
        'password', 'remember_token','verification_token',
    ];
   
    //set mutators for name
    public function setNameAttribute($name){
        $this->attributes['name']=$name;
    }
    //sset accessors for name
    public function getNameAttribute($name){
        return ucwords($name);
    }
    //set mutators for email
    public function setEmailAttribute($email){
        $this->attributes['email']=strtolower($email);
    }

    public function isVerified(){
        return $this->verified==User::VERIFIED_USER;
    }
 
    public function is_admin(){
        return $this->admin==User::ADMIN_USER;
    }
    public static function generateVerificationCode(){
        return str_random(40);
    }
    const ACTIVE_USER= '1';
    const INACTIVE_USER= '0';
    public function isActive(){
       return $this->active==User::ACTIVE_USER;
   }
}
