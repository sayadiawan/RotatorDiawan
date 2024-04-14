<?php

namespace Modules\Home\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Employee\Entities\Employee;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('home::index');
    }
}