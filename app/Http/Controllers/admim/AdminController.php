<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index(){
        return view('admin.pages.home',[
            'title'=>'Dashboard',
            'task'=>Task::orderbyDesc('id')->where('user_id',Auth::user()->id)->get(),
            'user'=>User::select('id','name','level')->get(),
            'sum_user'=>User::where('level',2)->count(),
            'sum_task'=>Task::where('status_nv',0)->count(),
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function users(){
        if( Auth::user()->level == 1){
            return view('admin.pages.users.users',[
                'title'=>'User management',
                'user'=>User::all(),
            ]);
        } else {
            return redirect()->route('login');
        }
    }
    public function create(){
        if( Auth::user()->level == 1){
            return view('admin.pages.users.adduser',[
                'title'=>'Add new'
            ]);
        } else{
            return redirect()->route('login');
        }

    }
    public function store(Request $request){
        try {
            User::create([
                'email'=>(string) $request->input('email'),
                'name'=>(string) $request->input('name'),
                'start'=> $request->input('start'),
                'end'=> $request->input('end'),
                'status'=>(int) $request->input('status'),
                'password'=> bcrypt('123')
            ]);
            Session::flash('success','Added user successfully');
        }catch (\Exception $err){
            Session::flash('error','Add user failed');
        }
        return redirect()->back();
    }
    public function show(User $u){
        if( Auth::user()->level == 1){
            return view('admin.pages.users.edituser',[
                'title'=>'Edit user',
                'u'=>$u,
            ]);
        } else{
            return redirect()->route('login');
        }
    }
    public function update(User $u, Request $request){
        if( Auth::user()->level == 1 ){
            $result = $u->fill($request->input());
            $u->save();
            if($result){
                Session::flash('success','Edit user successfully');
                return redirect()->route('users');
            }
            else {
                Session::flash('error','Fix user failed');
                return redirect()->back();
            }
        } else{
            return redirect()->route('login');
        }
    }
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        if( Auth::user()->level == 1){
            $id = (int) $request->input('id');
            $user = User::where('id', $id)->first();
            if($user){
                $del =  User::where('id',$id)->delete();
                if($del){
                    return Response()->json([
                        'error'=>false,
                        'message'=>'User successfully deleted'
                    ]);
                }else{
                    return Response()->json([
                        'error'=>true,
                    ]);
                }
            } else{
                return Response()->json([
                    'error'=>true,
                ]);
            }

        } else{
            return redirect()->route('login');
        }

    }
    public function grant(User $u)
    {
        if( Auth::user()->level == 1){
            $user = DB::table('users')
                ->where('id', $u->id)
                ->update(['level' =>$u->level -1]);
            if($user){
                Session::flash('success','Permission upgrade successful');
            }else{
                Session::flash('error','An error has occurred');
            }
            return redirect()->back();
        } else{
            return redirect()->route('login');
        }
    }
    public function lock(User $u)
    {
        if( Auth::user()->level == 1){
            $user = DB::table('users')
                ->where('id', $u->id)
                ->update(['lock' =>0]);
            if($user){
                Session::flash('success','Account locked successfully');
            }else{
                Session::flash('error','An error has occurred');
            }
            return redirect()->back();
        } else{
            return redirect()->route('login');
        }
    }
    public function unlock(User $u)
    {
        if( Auth::user()->level == 1){
            $user = DB::table('users')
                ->where('id', $u->id)
                ->update(['lock' =>1]);
            if($user){
                Session::flash('success','Account Unlocked Successfully');
            }else{
                Session::flash('error','An error has occurred');
            }
            return redirect()->back();
        } else{
            return redirect()->route('login');
        }
    }
    public function up_profile(Request $request){
        if ($_FILES['image']['name'] != NULL) {
            if ($_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/png" || $_FILES['image']['type'] == "image/gif") {
                $path = "public/images/user";
                $tmp_name = $_FILES['image']['tmp_name'];
                $temp = explode(".", $_FILES["image"]["name"]);
                $newfilename = round(microtime(true)).'-'.Auth::user()->id. '.' . end($temp);
                move_uploaded_file($tmp_name, $path . $newfilename);
                $image_url = $path . $newfilename;
                $img = User::where('id',Auth::user()->id)->update(['avatar' => $image_url]);
                if($img){
                    if($request->input('link')!="")
                    {
                        $link = $request->input('link');
                        unlink($link);
                    }
                }
            } else {
                Session::flash('error','Not an image file');
                return false;
            }
        }
        if(Auth::user()->level == 1){
            User::where('id',Auth::user()->id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'status' => $request->input('status'),
            ]);
        }
        Session::flash('success','Update successful');
        return redirect()->back();
    }
    public function up_pass(Request $request){
        if(Auth::attempt([
            'id'=>Auth::user()->id,
            'password' => $request->input('password_now')
        ])){
            if($request->input('password_new') == $request->input('cf_password_new')){
                $us = User::where('id',Auth::user()->id)->update(['password' => bcrypt($request->input('password_new'))]);
                if($us){
                    Session::flash('success','Change password successfully');
                    return redirect()->back();
                }else {
                    Session::flash('error','Password change failed');
                    return redirect()->back();
                }
            } else {
                Session::flash('error','Password incorrect');
                return redirect()->back();
            }
        } else{
            Session::flash('error','Current password is incorrect');
            return redirect()->back();
        }
    }
}
