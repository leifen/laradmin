<?php

namespace Sundy\Laradmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index()
    {
        return view('vendor.laradmin.indexs.index');
    }

    public function main()
    {
        return view('vendor.laradmin.indexs.main');
    }
}
