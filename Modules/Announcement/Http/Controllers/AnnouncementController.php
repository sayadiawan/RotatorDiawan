<?php

namespace Modules\Announcement\Http\Controllers;

use App\Models\Option;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = Option::first();
        return view('announcement::form',compact('data'));
    }

    public function store()
    {
        $data = Option::first();
        $data->announcement_option = request('announcement');
        $data->save();
        return response()->json(['status'=>true]);
    }
}
