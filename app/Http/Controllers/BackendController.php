<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{
    //
    function welcome(){
        return view('welcome');
    }

    function dashboard(){
        return view('dashboard');
    }
}
