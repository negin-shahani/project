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
    public function addlevels(){
        return view('admin.addlevels');
    }
    public function updatelevels(Request $request){

    $folderName = "../public/argon/levels/level-". $request -> level ."/". $request -> name;
    if (!file_exists($folderName)) {
        mkdir($folderName);
    }else {
       return back()-> with('nameError','there is a problem with this name'); 
    }
    $allowed = array('jpg', 'jpeg', 'png');
    $file1 = $_FILES['file1'];
    $fileName1 = $_FILES['file1']['name'];
    $fileTmpName1 = $_FILES['file1']['tmp_name'];
    $fileSize1 = $_FILES['file1']['size'];
    $fileError1 = $_FILES['file1']['error'];
    $fileType1 = $_FILES['file1']['type'];
    $fileExt1 = explode('.', $fileName1); 
    $fileActualExt1 = strtolower(end($fileExt1));   
    if (in_array($fileActualExt1, $allowed)) {
        if ($fileError1 === 0) {
            if ($fileSize1 < 1000000) {
                $fileNameNew1 = "pic1.".$fileActualExt1;
                $fileDestination1 = $folderName.'/'.$fileNameNew1;
                move_uploaded_file($fileTmpName1, $fileDestination1);
            }else{
               return back()-> with('pic1',"your file is too big!");
            }
        }else{
                return back()-> with('pic1',"there was an error uploading your file!");
        }       
    }else{
        return back()-> with('pic1', "you cannot upload files of this type!");
    }
     $file2 = $_FILES['file2'];
    $fileName2 = $_FILES['file2']['name'];
    $fileTmpName2 = $_FILES['file2']['tmp_name'];
    $fileSize2 = $_FILES['file2']['size'];
    $fileError2 = $_FILES['file2']['error'];
    $fileType2 = $_FILES['file2']['type'];
    $fileExt2 = explode('.', $fileName2); 
    $fileActualExt2 = strtolower(end($fileExt2));   
    if (in_array($fileActualExt2, $allowed)) {
        if ($fileError2 === 0) {
            if ($fileSize2 < 1000000) {
                $fileNameNew2 = "pic2.".$fileActualExt2;
                $fileDestination2 = $folderName.'/'.$fileNameNew2;
                move_uploaded_file($fileTmpName2, $fileDestination2);
            }else{
                return back()-> with('pic2', "your file is too big!");
            }
        }else{
                return back()-> with('pic2', "there was an error uploading your file!");
        }       
    }else{
        return back()-> with('pic2', "you cannot upload files of this type!");
    }  
    $file3 = $_FILES['file3'];
    $fileName3 = $_FILES['file3']['name'];
    $fileTmpName3 = $_FILES['file3']['tmp_name'];
    $fileSize3 = $_FILES['file3']['size'];
    $fileError3 = $_FILES['file3']['error'];
    $fileType3 = $_FILES['file3']['type'];
    $fileExt3 = explode('.', $fileName3); 
    $fileActualExt3 = strtolower(end($fileExt3));   
    if (in_array($fileActualExt3, $allowed)) {
        if ($fileError3 === 0) {
            if ($fileSize3 < 1000000) {
                $fileNameNew3 = "pic3.".$fileActualExt3;
                $fileDestination3 = $folderName.'/'.$fileNameNew3;
                move_uploaded_file($fileTmpName3, $fileDestination3);
            }else{
                return back()-> with('pic3', "your file is too big!");
            }
        }else{
                return back()-> with('pic3', "there was an error uploading your file!");
        }       
    }else{
        return back()-> with('pic3', "you cannot upload files of this type!");
    }  




        return back()-> with('successMsg','updated');
    }

   

}
