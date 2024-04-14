<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class SampleController extends Controller
{
    public function home(){
        return view('sample.home');
    }
    public function table(){
        return view('sample.table');
    }
    public function form(){
        return view('sample.form');
    }
    public function all_form(){
        return view('sample.all_form');
    }
    public function notfound(){
        return view('sample.notfound');
    }
}
