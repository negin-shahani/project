<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as dc1;
use App\Http\Controllers\Doctor\DashboardController as dc2;
use App\Http\Controllers\Normal\DashboardController as dc3;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');





Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});



Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin']],
	function(){
		Route::get('dashboard',[dc1::class,'index'])->name('dashboard');
		Route::get('/edit/{id}', [dc1::class,'edit'])->name('edit');
		Route::post('/update/{id}', [dc1::class,'update'])->name('update');
		Route::delete('/delete/{id}', [dc1::class,'delete'])->name('delete');
		Route::get('/editprofile', [dc1::class,'editprofile'])->name('editprofile');
		Route::get('reports',[dc1::class,'reports'])->name('reports');
		Route::get('/editreports/{id}', [dc1::class,'editreports'])->name('editreports');
		Route::delete('/deletereports/{id}',[dc1::class,'deletereports'])->name('deletereports');
		Route::get('/addlevels',[dc1::class,'addlevels'])->name('addlevels');
		Route::post('/updatelevels', [dc1::class,'updatelevels'])->name('updatelevels');
});
Route::group(['as'=>'doctor.','prefix'=>'doctor','namespace'=>'Doctor','middleware'=>['auth','doctor']],
	function(){
		Route::get('dashboard',[dc2::class,'index'])->name('dashboard');
		Route::get('/edit/{id}', [dc2::class,'edit'])->name('edit');
		Route::post('/updatelevels/{id}', [dc2::class,'updatelevels'])->name('updatelevels');
		Route::post('/updatenotification/{id}', [dc2::class,'updatenotification'])->name('updatenotification');
		Route::get('/editprofile', [dc2::class,'editprofile'])->name('editprofile');
		Route::get('/report', [dc2::class,'report'])->name('report');
		Route::post('/makereport', [dc2::class,'makereport'])->name('makereport');
});

Route::group(['as'=>'normal.','prefix'=>'normal','namespace'=>'Normal','middleware'=>['auth','normal']],
	function(){
		Route::get('dashboard',[dc3::class,'index'])->name('dashboard');
		Route::get('/editprofile', [dc3::class,'editprofile'])->name('editprofile');
		Route::get('/report', [dc3::class,'report'])->name('report');
		Route::get('/messages', [dc3::class,'messages'])->name('messages');
		Route::post('/makereport', [dc3::class,'makereport'])->name('makereport');
		Route::get('/viewnotification/{id}', [dc3::class,'viewnotification'])->name('viewnotification');
		Route::delete('/deletenotification/{id}',[dc3::class,'deletenotification'])->name('deletenotification');
});





