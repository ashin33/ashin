<?php

namespace App\Http\Controllers;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct()
    {
    }

    function index(){
        return view('index');
    }
}
