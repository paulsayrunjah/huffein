<?php
use Illuminate\Support\Facades\DB;
use ActivityLog as Log;
use Illuminate\Http\Request;

//use Excel;
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

//Auth::routes();

Route::get('/', 'HomeController@index')->name('/');
Route::get('getGraphData', 'HomeController@getGraphData')->name('getGraphData');

Route::get('test/{name}', function (Request $request) {
  
   $user = \App\User::find(1);
   $old = $user->toArray();
   $user->update([
        "name" => $request->name,    
    ]);

    $log = collect([
        PERFOMED_ON => $user,
        CAUSED_BY => 1,
        LOG => "$user->email created loan"
    ]);

    $user->advancedlog($log, "Log");
});

Route::post("testImport", "HomeController@testImport")->name("testImport");