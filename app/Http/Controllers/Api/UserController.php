<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreeateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function createuser(CreeateUserRequest $request):JsonResponse{
        try{
           
            $data = $request->validated();
            $data['is_admin']=0;
            $user = User::create($data);

            return response()->json([
                'status'=> true,
                'message' => 'User Created Succesfully',
                'user' => $user
            ]);
        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }
    }

    public function login (LoginRequest $request){
        try {
            $data = $request->validated();

            if(!$this->attempt($data)){
                return response()->json([
                    'stauts' => false,
                    'errors' => ['Auth' => 'Wrong in Creadentials']

                ],401);
            }

            $user = User::where('email',$request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'Successfully login',
                'data' =>['user' => $user, 
                'token' => $user->createToken('API Token')->plainTextToken
            ],
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }
    }

    public function me(){
        try {
            $user = auth()->user();
            return response()->json([
                'status' => true,
                'message' => 'User Profile',
                'data' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }
        
    }

    private function attempt ($credentials=[]){
        try {
            $user = User::where('email',$credentials['email'])->first();
            if($user && Hash::check($credentials["password"],$user->password)){
                return true;
            }
            else{
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
