<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginSRequest;
use App\Models\Provider;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    use HttpResponses;
    public function login(LoginSRequest $loginsrequest){
        $data = $loginsrequest->validated();
        $access_token = $data['access_token'];
        $provider = $data['provider'];
        $provider_user = Socialite::driver($provider)->userFromToken($access_token);
        // dd($provider_user->id);
        $user = $this->findorcreate($provider_user,$provider);
        return $this->success([
            'user'=> $user,
            'token' => $user->createToken('API Token'.$user->name)->plainTextToken
        ],'Success Loign');
    }

    protected function findorcreate($provider_user,$provider){
        $user = User::where('email',$provider_user->email)->first();
        if($user){
            $log_provider = $user->provider()->where('provider',$provider)->where('provider_id',$provider_user->id)->first();
            if(!$log_provider){
                $data = [
                    'provider_id' => $provider_user->id,
                    'provider' => $provider,
                    'user_id' => $user->id
                ];
                Provider::create($data);
            }
            return $user;
        }
        $data = [
            'name' => $provider_user->name,
            'email' => $provider_user->email,
            'password' => '123456',
            'is_admin' => false,
        ];
        $user = User::create($data);

        $data = [
            'providre_id' => $provider_user->id,
            'provider' => $provider,
            'user_id' => $user->id,
        ];

        Provider::create($data);
        return $user;
    }
}
