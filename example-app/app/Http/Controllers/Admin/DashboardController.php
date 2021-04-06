<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index(){
    	$users= User::where('access', '!=' , 0)->paginate(5);
		return view('admin.dashboard',compact('users'));
	}

	public function edit($id){
     	$user= User::find($id);
     	$doctors= User::where('access', '=' , 1)->paginate(100);
    	return view('admin.edit' , compact('user') , compact('doctors'));
    }

    public function editprofile(){
    	return view('admin.editprofile');
    }

     public function update(Request $request , $id){
    	$user= User::find($id);
    	
    	if( $request -> doctor_id != "---" ){
            $user -> doctor_id = $request -> doctor_id;
        }
        if( $request -> access != "---" ){
            $user -> access = $request -> access;
        }
    	$user -> save();
    	return redirect(route('admin.dashboard')) -> with('successMsg','The user was updated');
    }

    public function delete($id){
     	$user= User::find($id)-> delete();
    	return redirect(route('admin.dashboard')) -> with('successMsg','The user was deleted');
    }
    public function reports(){
    	$reports= Report::select('name','familyname','text','reports.id')->leftJoin('users', 'users.id', '=', 'reports.user_id')->paginate(5);
		return view('admin.reports',compact('reports'));
    }
    public function editreports($id){
     	$report= Report::select('name','familyname','text','reports.id')->leftJoin('users', 'users.id', '=', 'reports.user_id')->find($id);
    	return view('admin.editreports' , compact('report'));
    }
    public function deletereports($id){
     	$user= Report::find($id)-> delete();
    	return redirect(route('admin.reports')) -> with('successMsg','The report was deleted');
    }

   

}
