<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreeateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\BrandRresource;
use App\Models\User;
use App\Models\Brand;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HttpResponses;

    public function createuser(CreeateUserRequest $request):JsonResponse{
        try{
           
            $data = $request->validated();
            if($data['is_admin']){
                $data_user = $request->only(['name','email','password','is_admin']);
                $user = User::create($data_user);

                $data_user["is_admin"]? $data_brand = $request->only(['name','address','logo_path']):$data_brand = null;
                $logo_path = $data_brand['logo_path']?$data_brand['logo_path']->store('logs','public'):null;
                $data_brand['logo_path'] = $logo_path;
                // dd($user->id);
                $data_brand['user_id'] = $user->id;
                $brand = Brand::create($data_brand);
                return $this->success(new BrandRresource($brand),'User and Brand Created Succesfully');
            }

            
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
