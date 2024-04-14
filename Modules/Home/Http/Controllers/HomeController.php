<?php

namespace Modules\Home\Http\Controllers;

use App\Models\Option;
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
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    { 
        $employees = Employee::where('status',1)->get();
        $option = Option::first();
        return view('home::index',compact('employees','option'));
    }
}