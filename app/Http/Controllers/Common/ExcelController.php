<?php

namespace App\Http\Controllers\Common;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
//use Excel;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export($filename, $data)
    {
        if (count($data) == 0) {
            throw new Exception('No data');
        }
        //dd(Excel::download(new UserExport($data), $filename.'.'.'xls'));
        return Excel::download(new UserExport($data), $filename.'.'.'xlsx');
    }
}
