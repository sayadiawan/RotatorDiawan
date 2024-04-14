<?php

namespace Modules\DeviceAttribute\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;
use Modules\Device\Entities\DeviceAttribute;

class DeviceAttributeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index(Request $request)
  {
    if (request()->ajax()) {
      $datas = DeviceAttribute::select(['id_device_atribute', 'type', 'name_device_atribute', 'code', 'created_at', 'updated_at'])->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name_device_atribute']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['type']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['code']), Str::lower($request->get('search')))) {
                return true;
              }

              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_module = get_module_id('deviceattribute');

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_module, auth()->user()->roles)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('deviceattribute.edit', $data->id_device_atribute) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_module, auth()->user()->roles)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_device_atribute . '" data-nama="' . $data->type . ' - ' . $data->name_device_atribute  . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          }

          return '
              <div class="d-inline-block">
                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end m-0" style="">
                  ' . $btn_edit . '
                  ' . $btn_hapus . '
                </div>
              </div>
          ';
        })
        ->rawColumns(['action'])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $get_module = get_module_id('deviceattribute');
    return view('deviceattribute::index', compact('get_module'));
  }

  public function rules($request)
  {
    $rule = [
      'type' => 'required',
      'name_device_atribute' => 'required',
      'code' => 'required',
    ];

    $pesan = [
      'type.required' => 'Type device attribute wajib diisi!',
      'name_device_atribute.required' => 'Name device attribute wajib diisi!',
      'code.required' => 'Kode device attribute wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('deviceattribute::create');
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
      DB::beginTransaction();

      try {
        $post = new DeviceAttribute();
        $post->type = $request->type;
        $post->name_device_atribute = $request->name_device_atribute;
        $post->code = $request->code;

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data device attribute berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data device attribute tidak berhasil disimpan!"
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
      }
    }
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    return view('deviceattribute::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $data = DeviceAttribute::findOrFail($id);
    return view('deviceattribute::edit', compact('data'));
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
      DB::beginTransaction();

      try {
        $post = DeviceAttribute::find($id);
        $post->type = $request->type;
        $post->name_device_atribute = $request->name_device_atribute;
        $post->code = $request->code;

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data device attribute berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data device attribute tidak berhasil disimpan!"
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();

        return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
  public function destroy($id)
  {
    $hapus = DeviceAttribute::where('id_device_atribute', $id)->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data device attribute berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data device attribute tidak berhasil dihapus!"], 400);
    }
  }
}