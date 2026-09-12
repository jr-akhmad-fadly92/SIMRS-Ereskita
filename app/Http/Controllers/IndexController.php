<?php

namespace App\Http\Controllers;
use Modules\Pegawai\Entities\Pegawai;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
