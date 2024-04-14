<?php

namespace Modules\Privileges\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Modules\Entities\Roles;
use Modules\Modules\Entities\Module;
use Illuminate\Support\Facades\Validator;
use Modules\Privileges\Entities\Privilege;
use Illuminate\Contracts\Support\Renderable;

class PrivilegesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function rules($request)
  {
    $rule = [
      'code_usergroup' => 'required',
      'name_usergroup' => 'required',
    ];

    $pesan = [
      'code_usergroup.required' => 'Kode hak akses wajib diisi!',
      'name_usergroup.required' => 'Nama hak akses wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  public function json()
  {
    $datas = Privilege::select(['id_usergroup', 'name_usergroup', 'code_usergroup', 'created_at', 'updated_at']);

    return Datatables::of($datas)
      ->addColumn('action', function ($data) {
        $id_module = get_module_id('privileges');

        $editButton = "";
        if (isAccess('update', $id_module, auth()->user()->roles)) {
          $editButton = '<button type="button" onclick="location.href=' . "'" . route('privileges.edit', $data->id_usergroup) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
        }

        $roleButton = "";
        if (isAccess('roles', $id_module, auth()->user()->roles)) {
          $roleButton = '<button type="button" onclick="location.href=' . "'" . route('privileges.roles', $data->id_usergroup) . "'" . ';" class="btn btn-sm btn-warning">Roles</button>';
        }

        //selalu bisa
        $detailButton = '<a class="dropdown-item" href="' . route('privileges.show', $data->id_usergroup) . '">Detail</a>';

        $deleteButton = "";
        if (isAccess('delete', $id_module, auth()->user()->roles)) {
          $deleteButton = '<a class="dropdown-item btn-delete" href="#hapus" data-id="' . $data->id_usergroup . '" data-nama="' . $data->name_usergroup . '">Hapus</a>';
        }

        return '
                <div class="btn-group">
                    ' . $roleButton . '
                    ' . $editButton . '
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        ' . $detailButton . '
                        ' . $deleteButton . '
                    </div>
                </div>
              ';
      })
      ->addColumn('set_tgl', function ($data) {
        return fdate($data->updated_at, 'HHDDMMYYYY');
      })
      ->addIndexColumn() //increment
      ->make(true);
  }

  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index(Request $request)
  {
    if (request()->ajax()) {
      $datas = Privilege::select(['id_usergroup', 'name_usergroup', 'code_usergroup', 'created_at', 'updated_at'])->get();

      return Datatables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name_usergroup']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['code_usergroup']), Str::lower($request->get('search')))) {
                return true;
              }

              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_module = get_module_id('privileges');

          //detail
          $btn_role = "";
          if (isAccess('roles', $id_module, auth()->user()->roles)) {
            $btn_role = '<button type="button" onclick="location.href=' . "'" . route('privileges.roles', $data->id_usergroup) . "'" . ';" class="btn btn-sm btn-warning">Roles</button>';
          }

          //selalu bisa
          $btn_detail = '<a class="dropdown-item" href="' . route('privileges.show', $data->id_usergroup) . '"><i class="fas fa-info me-1"></i> Detail</a>';

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_module, auth()->user()->roles)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('privileges.edit', $data->id_usergroup) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_module, auth()->user()->roles)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id . '" data-nama="' . $data->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
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
        ->addColumn('set_tgl', function ($data) {
          return fdate($data->updated_at, 'HHDDMMYYYY');
        })
        ->addColumn('authorization', function ($data) {
          $id_module = get_module_id('privileges');

          //detail
          $btn_role = "";
          if (isAccess('roles', $id_module, auth()->user()->roles)) {
            $btn_role = '<button type="button" onclick="location.href=' . "'" . route('privileges.roles', $data->id_usergroup) . "'" . ';" class="btn btn-sm btn-warning">Roles</button>';
          }

          return $btn_role;
        })
        ->rawColumns(['action', 'set_tgl', 'authorization'])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $get_module = get_module_id('privileges');
    return view('privileges::index', compact('get_module'));
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('privileges::create');
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
        $check = Privilege::where('code_usergroup', $request->code_usergroup)
          ->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Kode hak akses sudah tersedia silahkan gunakan kode hak akses yang berbeda!"], 200);
        } else {
          $post = new Privilege();
          $post->name_usergroup = $request->name_usergroup;
          $post->code_usergroup = $request->code_usergroup;

          $simpan = $post->save();

          DB::commit();

          if ($simpan == true) {
            return response()->json([
              'status' => true,
              'pesan' => "Data hak akses berhasil disimpan!"
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'pesan' => "Data hak akses tidak berhasil disimpan!"
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
    $data = Privilege::find($id);
    return view('privileges::show', compact('data'));
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $data = Privilege::find($id);
    return view('privileges::edit', compact('data'));
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
        $post = Privilege::find($id);

        if ($post->code_usergroup != $request->code_usergroup) {
          $check = Privilege::where('code_usergroup', $request->code_usergroup)
            ->first();

          if ($check == null) {
            $post->code_usergroup = $request->code_usergroup;
          } else {
            return response()->json(['status' => false, 'pesan' => 'Kode hak akses ' . $request->code_usergroup . ' telah tersedia. Silahkan gunakan kode lainnya.']);
          }
        }

        $post->name_usergroup = $request->name_usergroup;

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data hak akses berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data hak akses tidak berhasil disimpan!"
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
    $hapus = Privilege::where('id_usergroup', $id)->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data hak akses berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data hak akses tidak berhasil dihapus!"], 400);
    }
  }

  public function roles($id)
  {
    $role = new Roles;
    $modules = Module::where('upid_module', '0')->orderby('order_module', 'ASC')->get();
    $data = Privilege::find($id);
    return view('privileges::roles', compact('data', 'modules', 'role'));
  }

  public function role_store(Request $request)
  {
    DB::beginTransaction();

    try {
      $simpan = false;
      $modules = $request->module;

      foreach ($modules as $id_mdl => $mdl) {
        $post = Roles::firstOrNew(['usergroup_gmd' => $request->post('user_groupmodule'), 'module_gmd' => $id_mdl]);
        $post->usergroup_gmd = $request->post('user_groupmodule');
        $post->module_gmd = $id_mdl;
        $post->action_gmd = $mdl;
        $post->publish = $request->post('status')[$id_mdl] ?? 0;
        $simpan = $post->save();
      }

      DB::commit();

      if ($simpan == true) {
        return response()->json([
          'status' => true,
          'pesan' => "Authorization hak akses berhasil disimpan!"
        ], 200);
      } else {
        return response()->json([
          'status' => false,
          'pesan' => "Authorization hak akses tidak berhasil disimpan!"
        ], 200);
      }
    } catch (\Exception $e) {
      DB::rollback();

      return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
    }
  }
}