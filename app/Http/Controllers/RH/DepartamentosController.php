<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\RH\Departamento;
use Illuminate\Http\Request;

class DepartamentosController extends Controller
{
    public function index()
    {
        $departamento = Departamento::where('id_estatus', 1)->paginate(10);
        return view('rh.departamentos.index', compact('departamento'));
    }
}
