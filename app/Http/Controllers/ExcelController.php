<?php

namespace App\Http\Controllers;

use App\Imports\ChecadorImport;
use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function checadorImport()
    {
        Excel::import(new ChecadorImport, 'data.xlsx');
        return redirect('/')->with('success', 'All good!');
    }
}
