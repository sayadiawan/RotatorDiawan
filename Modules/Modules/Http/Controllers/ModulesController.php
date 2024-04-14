<?php

namespace Modules\Modules\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Modules\Entities\Module;
use Yajra\Datatables\Datatables;
use Modules\Modules\Entities\Roles;
use Illuminate\Support\Facades\Validator;

class ModulesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function rules($request)
  {
    $rule = [
      'name_module' => 'required|string|max:100',
      'code_module' => 'required|string|max:15',
      'link_module' => 'required|string',
      'icon_module' => 'required|string|max:50',
      'order_module' => 'required|numeric',
      'action_module' => 'required',
    ];

    $pesan = [
      'name_module.required' => 'Nama module wajib diisi!',
      'link_module.required' => 'Link module wajib diisi!',
      'icon_module.required' => 'Icon module wajib diisi!',
      'order_module.required' => 'Order number module wajib diisi!',
      'action_module.required' => 'Action module wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  public function json()
  {
    $datas = Module::select(['id_module', 'name_module', 'created_at', 'upid_module', 'link_module', 'order_module', 'updated_at']);

    return Datatables::of($datas)
      ->addColumn('action', function ($data) {
        $id_module = get_module_id('privileges');

        //selalu bisa
        $detailButton = '<a class="dropdown-item" href="' . route('modules.show', $data->id_module) . '">Detail</a>';
        $editButton = "";
        if (isAccess('update', $id_module, auth()->user()->roles)) {
          $editButton = '<button type="button" onclick="location.href=' . "'" . route('modules.edit', $data->id_module) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
        }
        $deleteButton = "";
        if (isAccess('delete', $id_module, auth()->user()->roles)) {
          $deleteButton = '<a class="dropdown-item btn-delete" href="#hapus" data-id="' . $data->id_module . '" data-nama="' . $data->name_module . '">Hapus</a>';
        }
        return '
                <div class="btn-group">
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
      ->addColumn('module', function ($data) {
        return $data->module->name_module ?? "Parent";
      })
      ->editColumn('created_at', function ($data) {
        return $data->created_at->format('Y/m/d');
      })
      ->editColumn('updated_at', function ($data) {
        return $data->updated_at->format('Y/m/d');
      })
      ->filterColumn('updated_at', function ($query, $keyword) {
        $query->whereRaw("DATE_FORMAT(updated_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
      })
      ->addIndexColumn() //increment;

      ->make(true);
  }

  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {
    $data = Module::select(['id_module', 'name_module', 'created_at', 'upid_module', 'link_module', 'order_module', 'updated_at'])
      ->where('upid_module', "0")
      ->orderBy('order_module', 'ASC')
      ->get();

    return view('modules::index', compact('data'));
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    $modules = Module::all()->where('upid_module', "0");
    return view('modules::create', compact('modules'));
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
        $check = Module::where('code_module', $request->code_module)
          ->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Kode module sudah tersedia silahkan gunakan kode module yang berbeda!"], 200);
        } else {
          $post = new Module();
          $post->upid_module = $request->post('upid_module') ?? 0;
          $post->code_module = $request->post('code_module');
          $post->name_module = $request->post('name_module');
          $post->link_module = $request->post('link_module');
          $post->icon_module = $request->post('icon_module');
          $post->order_module = $request->post('order_module');
          $post->action_module = $request->post('action_module');
          $post->description_module = $request->post('description_module');

          $simpan = $post->save();

          DB::commit();

          if ($simpan == true) {
            return response()->json([
              'status' => true,
              'pesan' => "Data module berhasil disimpan!"
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'pesan' => "Data module tidak berhasil disimpan!"
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
    $data = Module::find($id);
    return view('modules::show', compact('data'));
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $modules = Module::all()->where('upid_module', "0");
    $data = Module::find($id);
    return view('modules::edit', compact('data', 'modules'));
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
        $post = Module::find($id);

        if ($post->code_module != $request->code_module) {
          $check = Module::where('code_module', $request->code_module)
            ->first();

          if ($check == null) {
            $post->code_module = $request->code_module;
          } else {
            return response()->json(['status' => false, 'pesan' => 'Kode module ' . $request->code_module . ' telah tersedia. Silahkan gunakan kode lainnya.']);
          }
        }

        $post->upid_module = $request->post('upid_module') ?? 0;
        $post->name_module = $request->post('name_module');
        $post->link_module = $request->post('link_module');
        $post->icon_module = $request->post('icon_module');
        $post->order_module = $request->post('order_module');
        $post->action_module = $request->post('action_module');
        $post->description_module = $request->post('description_module');

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data module berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data pengguna tidak berhasil disimpan!"
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
    $hapus = Module::where('id_module', $id)->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data module berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data module tidak berhasil dihapus!"], 400);
    }
  }

  public function sort()
  {
    // $sortData = array();
    $sort = 1;
    foreach (request('main') as $key => $main) {
      if (is_array($main)) {
        $no = 1;
        foreach ($main as $a => $b) {
          $sortData[$b]['parent'] = $key;
          $sortData[$b]['sort'] = $no;
          $no++;
        }
      } else {
        // echo $main."<br>";
        $sortData[$main]['parent'] = "0";
        $sortData[$main]['sort'] = $sort;
        $sort++;
      }
    }

    foreach ($sortData as $id => $data) {
      $id = str_replace("mdl-", "", $id);
      $parent = str_replace("mdl-", "", $data['parent']);

      $set =  Module::find($id);
      $set->order_module = $data['sort'];
      $set->upid_module = $parent;
      $set->save();
    }
  }
}