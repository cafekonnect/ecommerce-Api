<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
class UserController extends ApiController
{
    public function index()
    {
      //  $this->allowedAdminAction();
        $users=User::all();
       
     return response()->json(['data'=>$users],200);
    }



 
    public function show(User $user)
    {
        return response()->json($user);
    }

	

    public function update(Request $request, User $user)
    {
       
        $rules=[
            'email'=>'email|unique:users,email' . $user->id,
            'password'=>'min:6|confirmed',
            'admin'=> 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,

        ];

            if($request->has('name')){
                $user->name=$request->name;
            }

            if($request->has('email')  && $user->email !=$request->email){
                $user->verified=User::UNVERIFIED_USER;
                $user->verification_token=User::generateVerificationCode();
                $user->email=$request->email;
            }
            
            if ($request->has('password')){
                $user->password=bcrypt($request->password);
            }
            
            if($request->has('admin')){
                if(!$user->isVerified()){
                   return $this->errorResponse(['error'=> 'Only Verified users  can modify the admin field', 'code'=>409],409);
                 // return response()->json(['error'=> 'Only Verified users  can modify the admin field', 'code'=>409],409);
                }
                $user->admin=$request->admin;
            }
            if(!$user->isDirty()){
          //  return response()->json(['error'=>'You need  to specify  something for an update' , 'code'=>422],422);
              return $this->errorResponse(['error'=>'You need  to specify  something for an update' , 'code'=>422],422);
            }
       
       $user->save();
       return $this->showOne($user);
       // return response()->json(['data'=>$user],200);
    }

    public function store(Request $request)
    {

        $validation=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            
        ]);
       if(
           $validation->fails()){
            return response()->json(['message'=>$validation->messages()->all()],200);
           } else{
               try{
                $data=$request->all();
           
                $data['password']= bcrypt($request->password);
                $data['verified']= User::UNVERIFIED_USER;
                $data['verification_code']=User::generateVerificationCode();
                $data['admin']=User::REGULAR_USER;
                $user=User::create($data);
                return response()->json(['data'=>$user],201);
               }catch(\Exception $e){
            return response()->json(['message'=> $e->getMessage()],422);
               }
    }


    }


    public function destroy(User $user)
    {
       try{ 
                   $user->delete();
        return $this->showOne($user);
      // return response()->json(['data'=>$user],200);
       }catch(\Exception $e){
        return response()->json(['message'=> $e->getMessage()],422);
       }
    }
    

public function verify($token){
    $user=User::where('verification_token',$token)->firstOrFail();
    $user->verified=User::VERIFIED_USER;
    $user->verification_token=null;
    $user->save();
    return response()->json('The account has been successfully verified');
}



}
