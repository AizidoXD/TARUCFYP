<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class ExcelController extends Controller {

    public function index() {
        return view('uploadExcel');
    }

    public function importExcel(Request $request) {
        $file = $request->file('file');
        $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

        if ($ext === 'csv') {
            $dateTime = date('Ymd_His');
            $fileName = $dateTime . '-' . $file->getClientOriginalName();
            $savePath = public_path('/Excel/Test/');
            $file->move($savePath, $fileName);

            return redirect()->back()
                            ->with(['success' => 'File uploaded successfully.']);
        } else {
            return redirect()->back()
                            ->with(['errors' => 'The file format must be in CSV']);
        }
    }

}
