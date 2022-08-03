<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;



class UserController extends Controller
{
    function login(Request $req)
    {
       Validator::make($req->all(), array(
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(3)],
            'email' => 'required|email'
        ), [
            'password.required' => 'şifrenizi yazmadınız lütfen yazınız !',
            'email.required' => 'email yazmadınız lütfen yazınız !'
        ])->validate();

        $user = User::where(['email' => $req->email])->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return redirect('/login')->withErrors([
                'msg' => "username or password is not matched"
            ]);
        } else {
            $req->session()->put('user_id', $user->id);
            return redirect('/home');
        }
    }

    function register(Request $req)
    {
        // for password ;
        //Require at least one uppercase and one lowercase letter...
        //Require at least one number...
        // Require at least one letter...
        // Require at least one symbol...
        // Ensure the password appears less than 3 times in the same data leak...

        $data = Validator::make($req->all(), array(
            'fname' => 'required|max:50',
            'lname' => 'required|max:50',
            'username' => 'required|max:50|unique:users,username',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(3)],
            'email' => 'required|email|unique:users,email'
        ), [
            'fname.required' => 'isminizi yazmadınız lütfen yazınız !',
            'lname.required' => 'soy isminizi yazmadınız lütfen yazınız !',
            'username.required' => 'kullanıcı adı yazmadınız lütfen yazınız !',
            'password.required' => 'şifre yazmadınız lütfen yazınız !',
            'email.required' => 'email yazmadınız lütfen yazınız !',
            'fname.max' => 'isminiz maksimum 50 karakter uzunluğunda olabilir',
            'lname.max' => 'soy isminizi maksimum 50 karakter uzunluğunda olabilir',
            'username.max' => 'kullanıcı adınız maksimum 50 karakter uzunluğunda olabilir',
            'username.unique' => 'bu kullanıcı adı daha önce alındı!',
            'email.unique' => 'bu email daha önce alındı!'
        ])->validate();

        $user = new User;
        $user->fname=$req->fname;
        $user->lname=$req->lname;
        $user->email=$req->email;
        $user->username=$req->username;
        $user->password = Hash::make($req->password);
        $user->save();
        return redirect('/login');
    }


    function index(Request $req){

        $allUsers = User::all();

        return view('/home', [
            'users' => $allUsers
        ]);
    }
}
