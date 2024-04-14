<?php

namespace Modules\Position\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Position\Entities\Positions;
use Validator;
use DataTables;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //rules
    public function rules($request)
    {
        $rule = [
            'name_position' => 'required',
        ];
        $pesan = [
            'name_position.required' => 'Nama Jabatan Wajib di isi',
        ];
        return Validator::make($request, $rule, $pesan);
    }
    //load datatables
    public function json()
    {
        $datas = Positions::select(['id_position', 'name_position', 'updated_at']);

        return Datatables::of($datas)
            ->addColumn('action', function ($data) {
                //get module akses
                $id_module = get_module_id('position');

                //detail
                $btn_detail = '';
                if (isAccess('detail', $id_module, auth()->user()->roles)) {
                    $btn_detail = '<a class="dropdown-item" href="' . route('position.show', $data->id_position) . '">Detail</a>';
                }

                //edit
                $btn_edit = '';
                if (isAccess('detail', $id_module, auth()->user()->roles)) {
                    $btn_edit = '<button type="button" onclick="location.href=' . "'" . route('position.edit', $data->id_position) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
                }

                //delete
                $btn_hapus = '';
                if (isAccess('detail', $id_module, auth()->user()->roles)) {
                    $btn_hapus = '<a class="dropdown-item btn-hapus" href="#hapus" data-id="' . $data->id_position . '" data-nama="' . $data->name_position . '">Hapus</a>';
                }
                return '
                <div class="btn-group">
                    ' . $btn_edit . '
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        ' . $btn_detail . '
                        ' . $btn_hapus . '
                    
                    </div>
                </div>
              ';
            })
            ->addColumn('tgl', function ($data) {
                return fdate($data->updated_at, "HHDDMMYYYY");
            })
            ->addIndexColumn() //increment
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $get_module = get_module_id('position');
        return view('position::index', compact('get_module'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('position::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = $this->rules($request->all());
        if ($validator->fails()) {
            return response()->json(['status' => false, 'pesan' => $validator->errors()]);
        } else {
            $new_data = new Positions();
            $new_data->name_position = $request->name_position;
            $new_data->save();

            return response()->json(['status' => true]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $get_data = Positions::find($id);
        return view('position::show', compact('get_data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $get_data = Positions::find($id);
        return view('position::edit', compact('get_data'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = $this->rules($request->all());
        if ($validator->fails()) {
            return response()->json(['status' => false, 'pesan' => $validator->errors()]);
        } else {
            $new_data = Positions::find($id);
            $new_data->name_position = $request->name_position;
            $new_data->save();

            return response()->json(['status' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Positions::destroy($id);
        return response()->json(['status' => true]);
    }
}