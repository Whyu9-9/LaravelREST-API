<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){
        $creds=$request->only(['email','password']);

        if(!$token=JWTAuth::attempt($creds)){
            return response()->json([
                'success'=> false,
                'message'=>'Email/Password Salah!'
            ]);
        }
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public function register(Request $request){
        $encryptedPass = Hash::make($request->password);

        $user = new User;

        try{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $encryptedPass;
            $user->save();
            return $this->login($request);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>''.$e
            ]);
        }
    }

    public function logout(Request $request){
        try{
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success'=>true,
                'message'=>'Logout Berhasil'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>''.$e
            ]);
        }
    }

    public function saveUserInfo(Request $request){
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->age = $request->age;
        $photo = '';
        if($request->photo != null){
            $photo = time().'.jpg';
            file_put_contents('profiles/'.$photo,base64_decode($request->photo));
            $user->photo = $photo;
        }else{
            $photo = 'profile.png';
            $user->photo = $photo;
        }

        $user->update();

        return response()->json([
            'success'=>true,
            'user'=>$user
        ]);
    }
    
    public function editUserInfo(Request $request){
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->age = $request->age;
        $user->email = $request->email;
        $photo = '';
        if($request->photo != null){
            $photo = time().'.jpg';
            file_put_contents('profiles/'.$photo,base64_decode($request->photo));
            $user->photo = $photo;
        }

        $user->update();

        return response()->json([
            'success'=>true,
            'user' => $user
        ]);
    }
    
    public function editPass(Request $request){
        $user = User::find(Auth::user()->id);

        $savedPass = $user->password;
        $getPass = $request->password;
        $newPass = Hash::make($request->newPass);
        if(Hash::check($getPass, $savedPass)){
            $user->password = $newPass;
            $user->save();
            return response()->json([
                'success' => true
            ]);
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }
    
    public function read(Request $request){
        $user = User::find(Auth::user()->id);
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
    
}
