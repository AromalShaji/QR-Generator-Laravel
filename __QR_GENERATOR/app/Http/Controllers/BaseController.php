<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function index(Request $request){
        return View('index');
    }

    public function college(Request $request){
        return View('college');
    }
}