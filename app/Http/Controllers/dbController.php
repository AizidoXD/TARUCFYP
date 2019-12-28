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
        $files->date = date("Y-m-d");
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
    
    public function retrieveDB(){
        //do your retrieve db record coding here
    }
}
