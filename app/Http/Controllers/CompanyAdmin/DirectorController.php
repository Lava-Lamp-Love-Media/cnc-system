<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DirectorController extends Controller
{

    public function index()
    {
        return view('backend.companyadmin.director.index');
    }
    public function show()
    {
        return view('backend.companyadmin.director.show');
    }
}
