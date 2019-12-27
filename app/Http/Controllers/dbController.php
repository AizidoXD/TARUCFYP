<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dbController extends Controller
{
    public function index(Request $request){
//        dd($request->all());
        $size = $request->input('size');
        for($i = 0; $i < $size; $i++){
            $arr = explode(",",$request->input($i));
            printf ("No:" . $i . " " . $arr[0] . " " . $arr[1] . " " . $arr[2] . "\n");
        }
    }
}
