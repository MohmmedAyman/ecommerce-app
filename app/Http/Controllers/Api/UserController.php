<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreeateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HttpResponses;

    public function createuser(CreeateUserRequest $request):JsonResponse{
        try{
           
            $data = $request->validated();
            $data['is_admin']=0;
            $user = User::create($data);

           return $this->success($user,'User Created Succesfully');
           
        } catch(\Throwable $th){
            return $this->erorr(null,$th->getMessage(),500);
        }
    }

    public function login (LoginRequest $request){
        try {
            $data = $request->validated();


            if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                return $this->erorr(null,'Wrong in Creadentials',401);
            }

            $user = User::where('email',$request->email)->first();

            return $this->success([
                'user'=> $user,
                'token'=> $user->createToken('API Token'.$user->name)->plainTextToken
            ],'Successfully login');

        } catch (\Throwable $th) {
            return $this->erorr(null,$th->getMessage(),500);
        }
    }

    public function me(){
        try {
            $user = Auth::user();
            return $this->success($user,'User Profile');
        } catch (\Throwable $th) {
            return $this->erorr(null,$th->getMessage(),500);
        }
        
    }

    public function logout(){
        try{
            Auth::user()->currentAccessToken()->delete();
    
            return $this->success(['message'=>'you are now loggout']);
        } catch (\Throwable $th) {
            return $this->erorr(null,$th->getMessage(),500);
        }
    }

}
