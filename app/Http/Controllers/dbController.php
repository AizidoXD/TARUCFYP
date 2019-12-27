<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dbController extends Controller
{
    public function index(Request $request){
        dd($request->all());
//        for($i = 0; $i < $request->input('size'); $i++){
//            $arr = explode(",",$request->input('0'));
//            printr($arr);
//        }
    }
}
