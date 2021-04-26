<?php

namespace App\Http\Controllers\Normal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\User_notification;
use App\Models\User_log;

class DashboardController extends Controller
{
    public function index(){
    	$logs= User_log::where('user_id', '=' ,  auth()->user()->id)->orderBy('id', 'desc')->paginate(20);
		return view('normal.dashboard' ,compact('logs') );
	}
	public function messages(){
    	$notifications= User_notification::where('user_id', '=' , auth()->user()->id)->paginate(5);
		return view('normal.messages' ,compact('notifications'));
	}
	public function editprofile(){
    	return view('normal.editprofile');
    }
    public function report(){
    	return view('normal.report');
    }
     public function makereport(Request $request){
    	$this->validate($request,[
    		'text' => 'required'
    	]);
    	$notification= new Report;
    	$notification -> user_id = auth()->user()->id;
    	$notification -> text= $request -> text;
    	$notification -> save();
    	return back()-> with('successMsg2','done');

    }
    public function viewnotification($id){
     	$report= User_notification::find($id);
    	return view('normal.viewnotification' , compact('report'));
    }
    public function deletenotification($id){
        $user= User_notification::find($id)-> delete();
        return redirect(route('normal.messages')) ->  with('successMsg','The notification was deleted');
    }
}
