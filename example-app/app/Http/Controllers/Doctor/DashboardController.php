<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\User_notification;
use App\Models\User_log;

class DashboardController extends Controller
{
    public function index(){
		$users= User::where('doctor_id', '=' , auth()->user()->id)->paginate(5);
		return view('doctor.dashboard',compact('users'));
	}
	public function edit($id){
     	$user= User::find($id);
        $logs= User_log::where('user_id', '=' , $id)->orderBy('id', 'desc')->paginate(20);
    	return view('doctor.edit' , compact('user'),compact('logs'));
    }
    public function editprofile(){
    	return view('doctor.editprofile');
    }

    public function updatelevels(Request $request , $id ){
    	$user= User::find($id);
        $count=0;$string='';       
        if (isset($request ->l1)) {
           $count++;
           $string=$string.'1';
        }
        if (isset($request ->l2)) {
           $count++;
           $string=$string.'2';
        }
        if (isset($request ->l3)) {
           $count++;
           $string=$string.'3';
        }
        if (isset($request ->l4)) {
           $count++;
           $string=$string.'4';
        }
        if (isset($request ->l5)) {
           $count++;
           $string=$string.'5';
        }
        if ($count<2) {
            return back()->with('errorMsg','at least 2 buttons should be selected');
        }
        $user->levels=substr($string, 0,1)."-".substr($string, -1);
    	$user -> save();	
    	return back()-> with('successMsg','updated');
    }
    public function updatenotification(Request $request , $id ){

    	$this->validate($request,[
    		'text' => 'required'
    	]);
    	$notification= new User_notification;
    	$notification -> user_id = $id;
    	$notification -> text= $request -> text;
    	$notification -> save();
    	return back()-> with('successMsg2','done');

    }
    public function report(){
    	return view('doctor.report');
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



}
