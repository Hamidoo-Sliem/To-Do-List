<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('guest:web',['only'=>['_logout']]);
     }

    public function _signin () {
        if(!Auth::check()) {
         return view('auth.login');
        }else{
            return redirect()->route('HOME'); 
        }
    }

    public function _login (Request $req) {

       $req->validate([
            'email' => ['required','email'],
            'password' => ['required'],
          ],[
            'email.required' => 'You must add an email',
            'email.email' => 'This not an email you must add a valid email',
            'password.required' => 'You must add a password',
          ]);

          if($req->has('remember')){
            $rem = true;
          }else {
            $rem = false;
          }

        $attempt = Auth::attempt(['email' => $req['email'],'password' => $req['password']],$rem);
        if (!$attempt) {
            return back()->with('msg','Login failed! : may be password or email is incorrect');
        }
         return redirect()->route('HOME'); 
     }


     public function _signup () {
        return view('auth.register');
     }

     public function _register(Request $req){

        $req->validate([
          'name' => ['required'],
          'email' => ['required','email','unique:users'],
          'password' => ['required','same:password_confirm','min:6'],
        ],[
          'name.required' => 'You must add a user name',
          'email.required' => 'You must add an email',
          'email.email' => 'This not an email you must add a valid email',
          'email.unique' => 'This email is already existed you must use another',
          'password.required' => 'You must add a password',
          'password.same' => 'The password not the same of confirm password',
          'password.min' => 'The password must be a least 6 characters',
        ]);
 
         $user = User::insert([
             'name' => strip_tags(trim($req['name'])),
             'email' => $req['email'],
             'password' => Hash::make(strip_tags(trim($req['password']))),
             'created_at' => \DB::raw('NOW()')
         ]);
        
         return redirect()->route('LOG.F');
     }


     public function _logout() {
        Auth::logout(true);
        return redirect()->route('LOG.F');
     }

}
