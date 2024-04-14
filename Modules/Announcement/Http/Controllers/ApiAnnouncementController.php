<?php

namespace Modules\Announcement\Http\Controllers;

use App\Models\Option;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiAnnouncementController extends Controller
{
    public function data()
    {
        $data = Option::first();
        if ($data) {
            return response()->json(['announcement'=>$data->announcement_option,'status'=>true],200);
        }else{
            return response()->json(['result'=>'Data Kosong','status'=>false],400);
        }
    }
}