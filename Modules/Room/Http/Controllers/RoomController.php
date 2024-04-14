<?php

namespace Modules\Room\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Room\Entities\Room;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class RoomController extends Controller
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
      $datas = Room::select(['id_rooms', 'name_rooms', 'code_rooms', 'created_at', 'updated_at'])->get();

      return Datatables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name_rooms']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['code_rooms']), Str::lower($request->get('search')))) {
                return true;
              }

              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_module = get_module_id('room');

          //detail
          //selalu bisa
          $btn_detail = '';

          if (isAccess('update', $id_module, auth()->user()->roles)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('room.show', $data->id_rooms) . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_module, auth()->user()->roles)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('room.edit', $data->id_rooms) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_module, auth()->user()->roles)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_rooms . '" data-nama="' . $data->name_rooms . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          }

          return '
              <div class="d-inline-block">
                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end m-0" style="">
                  ' . $btn_detail . '
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

    $get_module = get_module_id('room');
    return view('room::index', compact('get_module'));
  }

  public function rules($request)
  {
    $rule = [
      'name_rooms' => 'required',
      'code_rooms' => 'required',
    ];

    $pesan = [
      'name_rooms.required' => 'Nama room wajib diisi!',
      'code_rooms.required' => 'Kode room wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('room::create');
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
        $check = Room::where('code_rooms', $request->code_rooms)
          ->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Kode room sudah tersedia silahkan gunakan kode room yang berbeda!"], 200);
        } else {
          $post = new Room();
          $post->name_rooms = $request->name_rooms;
          $post->code_rooms = $request->code_rooms;

          $simpan = $post->save();

          DB::commit();

          if ($simpan == true) {
            return response()->json([
              'status' => true,
              'pesan' => "Data room berhasil disimpan!"
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'pesan' => "Data room tidak berhasil disimpan!"
            ], 200);
          }
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
    $data = Room::find($id);
    return view('room::show', compact('data'));
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $data = Room::find($id);
    return view('room::edit', compact('data'));
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
        $post = Room::find($id);

        if ($post->code_rooms != $request->code_rooms) {
          $check = Room::where('code_rooms', $request->code_rooms)
            ->first();

          if ($check == null) {
            $post->code_rooms = $request->code_rooms;
          } else {
            return response()->json(['status' => false, 'pesan' => 'Kode room ' . $request->code_rooms . ' telah tersedia. Silahkan gunakan kode lainnya.']);
          }
        }

        $post->name_rooms = $request->name_rooms;

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data room berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data room tidak berhasil disimpan!"
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
    $hapus = Room::where('id_rooms', $id)->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data rooms berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data rooms tidak berhasil dihapus!"], 400);
    }
  }

  public function getRoomsBySelect2(Request $request)
  {
    $search = $request->search;

    if ($search == '') {
      $data = Room::orderby('name_rooms', 'asc')
        ->select('id_rooms', 'name_rooms', 'code_rooms')
        ->limit(10)
        ->get();
    } else {
      $data = Room::orderby('name_rooms', 'asc')
        ->select('id_rooms', 'name_rooms', 'code_rooms')
        ->where('name_rooms', 'like', '%' . $search . '%')
        ->limit(10)
        ->get();
    }

    $response = array();
    foreach ($data as $item) {
      $response[] = array(
        "id" => $item->id_rooms,
        "text" => $item->name_rooms . ' - ' . $item->code_rooms
      );
    }

    return response()->json($response);
  }
}