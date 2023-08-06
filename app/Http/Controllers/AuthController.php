<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\String\u;

class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginUserRequest $request){

        if(!Auth::attempt($request->only('email','password'))){
            return $this->error('','credentials do not match',401);
        }
        $user = User::where('email',$request->input('email'))->first();
        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('Api Token of' . $user->name)->plainTextToken
        ]);
    }
    public function register(StoreUserRequest $request){
        $user=User::create([
            'name' =>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password'))
        ]);
        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('Api Token of' . $user->name)->plainTextToken
        ]);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success'=> true,
            'message'=>'logout successful'
        ]);
    }

}
