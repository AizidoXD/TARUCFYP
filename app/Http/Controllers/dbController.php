<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\file;
use App\record;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class dbController extends Controller {

    public function index(Request $request) {
        $size = $request->input('size');
        $temp = [];
        $category = "";
        $findFK = "";

        //To take out the category
        for ($i = 0; $i < $size; $i++) {
            $arr = explode(",", $request->input($i));
            $temp[] = $arr[0];
        }

        //Combine the category to one string
        foreach ($temp as $value) {
            $category = $category . $value . ",";
        }

        //Insert file record
        $files = new file();
        $files->date = date("Y-m-d H:i:s");
        $files->name = date('Y-m-d H:i:s') . " " . "(" . $category . ")";
        $files->save();

        $findFK = date('Y-m-d H:i:s') . " " . "(" . $category . ")";

        $fileFK = DB::table('files')->where('name', $findFK)->value('id');

        //Insert record
        for ($i = 0; $i < $size; $i++) {
            $arr = explode(",", $request->input($i));

            $records = new record();
            $records->file_id = $fileFK;
            $records->category = $arr[0];
            $records->good = $arr[1];
            $records->bad = $arr[2];
            $records->save();
        }
    }

    public function retrieveDB(Request $request) {
        $recordFK = $request->filePK;
        $fileDate = DB::table('files')->select('date')->where('id', $recordFK)->get()->toArray();
        $fileName = DB::table('files')->select('name')->where('id', $recordFK)->get()->toArray();

        $Date = "";
        $Name = "";
        
        foreach($fileDate as $Date){
            $Date = $Date->date;
        }
        
        foreach($fileName as $Name){
            $Name = $Name->name;
        }
 
        $records = DB::table('records')->select('category', 'good', 'bad')->where('file_id', $recordFK)->get()->toArray();

        $arr_ranking = [];

        $arr_bus = [0, 0, 0];
        $arr_wifi = [0, 0, 0];
        $arr_adminService = [0, 0, 0];
        $arr_food = [0, 0, 0];
        $arr_parking = [0, 0, 0];
        $arr_timeTable = [0, 0, 0];
        $arr_lecturer = [0, 0, 0];
        $arr_outdoor = [0, 0, 0];
        $arr_facility = [0, 0, 0];

        foreach ($records as $row) {
            
            if ($row->category === "Bus") {
                $arr_bus[0] = $row->good;
                $arr_bus[1] = $row->bad;
                $arr_bus[2] = 1;
            }

            if ($row->category === "Wifi") {
                $arr_wifi[0] = $row->good;
                $arr_wifi[1] = $row->bad;
                $arr_wifi[2] = 1;
            }
            
            if ($row->category === "Admin") {
                $arr_adminService[0] = $row->good;
                $arr_adminService[1] = $row->bad;
                $arr_adminService[2] = 1;
            }

            if ($row->category === "Food") {
                $arr_food[0] = $row->good;
                $arr_food[1] = $row->bad;
                $arr_food[2] = 1;
            }

            if ($row->category === "Parking") {
                $arr_parking[0] = $row->good;
                $arr_parking[1] = $row->bad;
                $arr_parking[2] = 1;
            }
            
            if ($row->category === "TimeTable") {
                $arr_timeTable[0] = $row->good;
                $arr_timeTable[1] = $row->bad;
                $arr_timeTable[2] = 1;
            }

            if ($row->category === "Lecturer") {
                $arr_lecturer[0] = $row->good;
                $arr_lecturer[1] = $row->bad;
                $arr_lecturer[2] = 1;
            }
            
            if ($row->category === "Outdoor") {
                $arr_outdoor[0] = $row->good;
                $arr_outdoor[1] = $row->bad;
                $arr_outdoor[2] = 1;
            }
            
            if ($row->category === "Facility") {
                $arr_facility[0] = $row->good;
                $arr_facility[1] = $row->bad;
                $arr_facility[2] = 1;
            }
            
            $arr_ranking[$row->category] = $row->bad;
        }

        arsort($arr_ranking);

        return view('viewHistory')
                        ->with('arr_bus', $arr_bus)
                        ->with('arr_wifi', $arr_wifi)
                        ->with('arr_adminService', $arr_adminService)
                        ->with('arr_food', $arr_food)
                        ->with('arr_parking', $arr_parking)
                        ->with('arr_timeTable', $arr_timeTable)
                        ->with('arr_lecturer', $arr_lecturer)
                        ->with('arr_outdoor', $arr_outdoor)
                        ->with('arr_facility', $arr_facility)
                        ->with('arr_ranking', $arr_ranking)
                        ->with('fileDate', $Date)
                        ->with('fileName', $Name);
        
    }

}
