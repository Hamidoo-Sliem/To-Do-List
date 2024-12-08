<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public static $errors;

     public function __construct() {
        self::$errors = [];
        $this->middleware('guest:api',['only'=>['_logout']]);
     }


     public function _register(Request $req){

       $v = \Illuminate\Support\Facades\Validator::make($req->all(), [
         'name' => ['required'],
         'email' => ['required','email','unique:users'],
         'password' => ['required','confirmed','min:6'],
       ],[
         'name.required' => 'name:You must add a user name',
         'email.required' => 'email:You must add an email',
         'email.email' => 'email:This not an email you must add a valid email',
         'email.unique' => 'email:This email is already existed you must use another',
         'password.required' => 'password:You must add a password',
         'password.confirmed' => 'password:The password not equal the confirm password',
         'password.min' => 'password:The password must be a least 6 characters',
       ]);

      if(count($v->errors()->all()) === 0) { 

        $user = User::insertGetId([
            'name' => strip_tags(trim($req['name'])),
            'email' => $req['email'],
            'password' => Hash::make(strip_tags(trim($req['password']))),
            'created_at' => \DB::raw('NOW()')
        ]);

        $token = Auth::guard('api')->login(User::find($user));
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => Auth::guard('api')->user(),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

      }else {

        foreach($v->errors()->all() as $k=>$v) {
          if(str_contains($v,'name:')){
            self::$errors['name'] = str_ireplace('name:','',$v);
          }
          if(str_contains($v,'email:')){
            self::$errors['email'] = str_ireplace('email:','',$v);
          }
          if(str_contains($v,'password:')){
            self::$errors['password'] = str_ireplace('password:','',$v);
          }
        }

        return response()->json(["status" => "error","errors" => self::$errors]);
      }

    }


     public function _login (Request $req) {

        $v = \Illuminate\Support\Facades\Validator::make($req->all(), [
            'email' => ['required','email'],
            'password' => ['required'],
          ],[
            'email.required' => 'email:You must add an email',
            'email.email' => 'email:This not an email you must add a valid email',
            'password.required' => 'password:You must add a password',
          ]);

        if(count($v->errors()->all()) === 0) { 

        $token = Auth::guard('api')->attempt(['email' => $req['email'],'password' => $req['password']]);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized:Email or password is incorrect',
            ], 401);
        }
        $user = Auth::guard('api')->user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

        }else {

            foreach($v->errors()->all() as $k=>$v) {
              if(str_contains($v,'email:')){
                self::$errors['email'] = str_ireplace('email:','',$v);
              }
              if(str_contains($v,'password:')){
                self::$errors['password'] = str_ireplace('password:','',$v);
              }
            }
    
            return response()->json(["status" => "error","errors" => self::$errors]);
          }
    
     }
     

     public function _logout() {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
     }
}
