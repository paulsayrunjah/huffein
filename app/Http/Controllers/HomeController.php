<?php

namespace App\Http\Controllers;
use \App\InwardRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::now()->format("Y-m-d");
        $model = new InwardRecord;
        $inwardRecords = $model->whereDate("date", $today)->get();
        //dd($inwardRecords);
        return view('home', compact('inwardRecords'));
    }


    public function getGraphData(){
        $stats = \Perfomace::stats("date");

        return response()->json($stats);
    }

    public function testImport(Request $request)
    {
        if($request->hasFile('file')){
            Excel::load($request->file->getRealPath(), function($reader){
                $result_data = $reader->get();
                $heading = $result_data->first()->keys();
            
                //create table 
                if (!Schema::hasTable('imports_table')) {
                    Schema::create('imports_table', function ($table) use ($heading){
                        $table->increments('table_id');
                        foreach ($heading->toArray() as $value) {
                            $table->text($value)->nullable();
                        }
                        $table->timestamps();
                    });
                }

                //store data
                foreach ($result_data as $value) {
                    DB::table('imports_table')->insert($value->toArray());
                }

                
                
                dd($heading->toArray());
            });
        }
    }
}
