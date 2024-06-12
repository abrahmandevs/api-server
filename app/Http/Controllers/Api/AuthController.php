<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Models\User;
use App\Permissions\Abilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// api response traits
use App\Traits\apiResponses;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use apiResponses;
    // user login api request
    public function login(LoginUserRequest $request) :JsonResponse {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email','password'))) {
            return $this->error('Invalid cradintial',401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok('Login Successfull',[
            "user"=>$user,
            'token'=>$user->createToken('devise_name',Abilities::getAbilites($user),now()->addHour())->plainTextToken
        ]);
    }

    public function register(Request $request):JsonResponse{
        return $this->ok('re','data');
    }


    /* user logout
    *@parem request
    */
    public function logout(Request $request):JsonResponse{
        // $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        return $this->ok('Logout Successfull');
    }
}
