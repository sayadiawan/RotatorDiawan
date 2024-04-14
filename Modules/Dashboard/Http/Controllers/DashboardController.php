<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Modules\Entities\Module;

class DashboardController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function masterdata()
  {
    $master_modules = Module::where('upid_module', '9a7773d3-d090-4586-86eb-4a8c3804d199')->get();
    $title = "Master Data";
    return view('dashboard::masterdata', compact('master_modules', 'title'));
  }

  public function usermanagement()
  {
    $master_modules = Module::where('upid_module', '92b34539-1fc4-48d4-a97e-c5c9ec3e6d05')->get();
    $title = "User Management";
    return view('dashboard::masterdata', compact('master_modules', 'title'));
  }
}