<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function index(){
        if( Auth::user()->level == 1){
            $user =User::select('id','name','level')->get();
            return view('admin.pages.task.task',[
                'title'=>'Task',
                'task'=>Task::orderbyDesc('id')->get(),
                'user'=>$user,
            ]);
        } else{
            return redirect()->route('login');
        }

    }
    public function create(){
        if( Auth::user()->level == 1){
            $emp = User::orderbyDesc('id')->where('level',2)->get();
            return view('admin.pages.task.addtask',[
                'title'=>'Add new',
                'emp'=>$emp,
            ]);
        } else{
            return redirect()->route('login');
        }
    }
    public function store(Request $request){
        $pattern = [
            'mnvu' => 'required|max:12|min:6',
        ];
        $messenger = [
            'required'=>':attribute not be empty',
            'max'=>':attribute up to 12 characters',
            'min'=>':attribute at least 6 characters',
        ];
        $customName = [
            'mnvu' => 'Task code',
        ];
        $this->validate($request,$pattern,$messenger,$customName);
        try {
            Task::create([
                'mnvu'=>(string) $request->input('mnvu'),
                'name_nv'=>(string) $request->input('name_nv'),
                'start_nv'=> $request->input('start_nv'),
                'end_nv'=> $request->input('end_nv'),
                'user_id'=>$request->input('performer'),
                'creat_id'=>Auth::user()->id,
            ]);
            Session::flash('success','Added task successfully');
        }catch (\Exception $err){
            Session::flash('error','Add task failed');
        }
        return redirect()->back();
    }
    public function show(Task $t){
        if( Auth::user()->level == 1){
            return view('admin.pages.task.edittask',[
                'title'=>'Edit task',
                't'=>$t,
                'emp'=> User::orderbyDesc('id')->where('level',2)->get(),
            ]);
        } else{
            return redirect()->route('login');
        }
    }
    public function update(Task $t, Request $request){
        if( Auth::user()->level == 1 ){
            $result = $t->fill($request->input());
            $t->save();
            if($result){
                Session::flash('success','Edit task successfully');
                return redirect()->route('tasks');
            }
            else {
                Session::flash('error','Fix task failed');
                return redirect()->back();
            }
        } else{
            return redirect()->route('login');
        }
    }
    public function check(Request $request){
        $date = date('Y-m-d');
        $Check = Task::where('id', '=', $request->input('id_check'))->where('user_id', '=',  Auth::user()->id)->first();
        $Check->status_nv = 1;
        $Check->finish_nv = $date;
        $Check->save();
        if($Check){
            Session::flash('success','Edit task successfully');
            return redirect()->back();
        }
        else {
            Session::flash('error','Fix task failed');
            return redirect()->back();
        }
    }
}
