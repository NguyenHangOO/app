<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){
        return view('login.login',[
            'title'=>'Login',
        ]);
    }
    public function store(Request $request){

        $this->validate($request,[
            'password'=>'required'
        ]);

        if(Auth::attempt([
            'email'=>$request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            if($user->lock==1){
                return redirect()->route('admin');
            } else {
                Session::flash('error','Account has been locked');
                return redirect()->back();
            }

        }
        else {
            if(Auth::attempt([
                'id'=>$request->input('email'),
                'password' => $request->input('password')
            ], $request->input('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();
                if($user->lock==1){
                    return redirect()->route('admin');
                } else {
                    Session::flash('error','Account has been locked');
                    return redirect()->back();
                }

            }
            else{
                Session::flash('error','Incorrect account or password!');
                return redirect()->back();
            }

        }
    }
}
