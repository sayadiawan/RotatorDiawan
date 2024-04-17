<?php

namespace Modules\Site\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Modules\Icon\Entities\Icon;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Site\Entities\Site;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;






class SiteController extends Controller
{

  protected $firebase_premium;
  protected $database_premium;
  /**
   * Display a listing of the resource.
   * @return Renderable
   */

  public function __construct()
  {
    $this->middleware('auth');

  }

  public function rules($request)
  {
    $rule = [
      'name_devices' => 'required',
      'alias_devices' => 'required',
      'type' => 'required'
    ];
    $pesan = [
      'name_devices.required' => 'Nama device wajib diisi!',
      'alias_devices.required' => 'Nama alias device wajib diisi!',
      'type.required' => 'Type device wajib diisi!'
    ];

    return Validator::make($request, $rule, $pesan);
  }

 
  public function index(Request $request)
  {
    $get_module = get_module_id('site');


    if (Auth::user()->usergroup->code_usergroup == "SAS" || Auth::user()->usergroup->code_usergroup == "ADM") {
      $query = Site::latest();
    } else {
      $query = Site::latest()->where('users_id', Auth::user()->id);
    }

    // pakai ini jadul langsung lihat attribute di model smarthome
    /* if ($s = $request->input('search')) {
      $query->whereHas('user', function ($query) use ($s) {
        return $query->where('name', 'LIKE', '%' . $s . '%')
          ->whereNull('deleted_at');
      })
        ->orWhereHas('room', function ($query) use ($s) {
          return $query->where('name_rooms', 'LIKE', '%' . $s . '%')
            ->whereNull('deleted_at');
        });
    }
    */
    // $result = $query->paginate(1)->withQueryString(); 

    // dd($query);

    $result = $query
      // ->filter(request(['search']))
      ->paginate(10)
      ->withQueryString();

    return view('site::index', compact('get_module', 'result'));
    // if (request()->ajax()) {
    //   $datas = Site::select(['id_sites', 'name_devices', 'type', 'created_at'])
    //     ->orderBy('created_at', 'DESC')
    //     ->get();

    //   return Datatables::of($datas)
    //     ->filter(function ($instance) use ($request) {
    //       if (!empty($request->get('search'))) {
    //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
    //           if (Str::contains(Str::lower($row['name_devices']), Str::lower($request->get('search')))) {
    //             return true;
    //           } else if (Str::contains(Str::lower($row['type']), Str::lower($request->get('search')))) {
    //             return true;
    //           }

    //           return false;
    //         });
    //       }
    //     })
    //     ->addColumn('action', function ($data) {
    //       //get module akses
    //       $id_module = get_module_id('device');

    //       //detail
    //       $btn_detail = '';
    //       if (isAccess('detail', $id_module, auth()->user()->roles)) {
    //         $btn_detail = '<a class="dropdown-item" href="' . route('device.show', $data->id_sites) . '"><i class="fas fa-info me-1"></i> Detail</a>';
    //       }

    //       //edit
    //       $btn_edit = '';
    //       if (isAccess('update', $id_module, auth()->user()->roles)) {
    //         $btn_edit = '<a class="dropdown-item" href="' . route('device.edit', $data->id_sites) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
    //       }

    //       //delete
    //       $btn_hapus = '';
    //       if (isAccess('delete', $id_module, auth()->user()->roles)) {
    //         $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_sites . '" data-nama="' . $data->name_devices . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
    //       }

    //       $btn_command = '';
    //       if (isAccess('command', $id_module, auth()->user()->roles)) {
    //         $btn_command = '<a class="dropdown-item btn-command" href="/device/command/' . $data->id_sites . '" data-id="' . $data->id_sites . '" data-nama="' . $data->name_devices . '"><i class="fas fa-microphone"></i>  Command</a>';
    //       }

    //       return '
    //           <div class="d-inline-block">
    //             <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
    //               aria-expanded="false">
    //               <i class="bx bx-dots-vertical-rounded"></i>
    //             </a>

    //             <div class="dropdown-menu dropdown-menu-end m-0" style="">
    //               ' . $btn_detail . '
    //               ' . $btn_edit . '
    //               ' . $btn_hapus . '
    //               ' . $btn_command . '
    //             </div>
    //           </div>
    //       ';
    //     })
    //     ->addColumn('type', function ($data) {
    //       switch ($data->type) {
    //         case 'lamp':
    //           # code...
    //           return "Lampu";
    //           break;
    //         case 'humidifier':
    //           # code...
    //           return "Humidifier";
    //           break;
    //         case 'fan':
    //           # code...
    //           return "Fan";
    //           break;
    //         case 'door':
    //           # code...
    //           return "Door";
    //           break;
    //         case 'curtains':
    //           # code...
    //           return "Curtains";
    //           break;
    //         case 'ac':
    //           # code...
    //           return "AC (Air Conditioner)";
    //           break;
    //         case 'cctv':
    //           # code...
    //           return "CCTV (Closed Circuit Television)";
    //           break;
    //         default:
    //           # code...
    //           return "Window";
    //           break;
    //       }
    //     })
    //     ->rawColumns(['action', 'type'])
    //     ->addIndexColumn() //increment
    //     ->make(true);
    // };

    // $devices = Site::all();
    // $get_module = get_module_id('device');

    // return view('device::index', compact('devices', 'get_module'));
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    $data_icon = Icon::orderBy('created_at', 'desc')->get();
    return view('device::create', compact('data_icon'));
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
        $value_firebase = [];
        $id_sites = [];

        $device = new Site();
        $device->name_devices = $request->post('name_devices');
        $device->alias_devices = $request->post('alias_devices');
        $device->type = $request->post('type');
        $device->icons_id = $request->post('icons');
        $device->client_id = "c8879e6e-db31-44e4-905e-ee87f238076a";
        $simpan = $device->save();
        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data device berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data device tidak berhasil disimpan!"
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

 
  public function command($id)
  {
    $data = Site::find($id);


    $code = '
            //Client ID
            String clientId = "c8879e6e-db31-44e4-905e-ee87f238076a";
            //User ID
            String userId = "c8879e6e-db31-44e4-905e-ee87f238076a";
            //ID Site
            String idDevice = "' . $id . '";
            ';
    return view('device::command', ['get_data' => $data, 'code' => $code]);
  }


  public function show($id)
  {
    $data = Site::find($id);
    $code = '
            //Client ID
            String clientId = "c8879e6e-db31-44e4-905e-ee87f238076a";
            //User ID
            String userId = "c8879e6e-db31-44e4-905e-ee87f238076a";
            //ID Site
            String idDevice = "' . $id . '";
            ';
    return view('device::show', ['get_data' => $data, 'code' => $code, 'id' => $id]);
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $device = Site::find($id);
    $data_icon = Icon::orderBy('created_at', 'desc')->get();

    return view('device::edit', [
      'device' => $device,
      'data_icon' => $data_icon
    ]);
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
        $value_firebase = [];

        $device = Site::findOrFail($id);
        $device->name_devices = $request->post('name_devices');
        $device->alias_devices = $request->post('alias_devices');
        $device->type = $request->post('type');
        $device->icons_id = $request->post('icons');
        $simpan = $device->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data device berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data device tidak berhasil disimpan!"
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
  public function destroy(Request $request)
  {
    $id = $request->id;
    $query = Site::where('id_sites', $id);

    $device = $query->first();

  

    // final step hapus device (indukan)
    $hapus = $query->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data device berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data device tidak berhasil dihapus!"], 400);
    }
  }

  public function json()
  {
    $datas = Site::select(['id_sites', 'name_devices', 'type', 'created_at']);

    return Datatables::of($datas)
      ->addColumn('action', function ($data) {

        //get module akses
        $id_module = get_module_id('device');

        //detail
        $btn_detail = '';
        if (isAccess('detail', $id_module, auth()->user()->roles)) {
          $btn_detail = '<a class="dropdown-item" href="' . route('device.show', $data->id_sites) . '">Detail</a>';
        }

        //edit
        $btn_edit = '';
        if (isAccess('update', $id_module, auth()->user()->roles)) {
          $btn_edit = ' <button type="button" onclick="location.href=' . "'" . route('device.edit', $data->id_sites) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
        }

        //delete
        $btn_hapus = '';
        if (isAccess('delete', $id_module, auth()->user()->roles)) {
          $btn_hapus = '<a class="dropdown-item btn-hapus" href="#hapus" data-id="' . $data->id_sites . '" data-nama="' . $data->name_devices . '">Hapus</a>';
        }

        $btn_command = '';
        if (isAccess('command', $id_module, auth()->user()->roles)) {
          $btn_command = '<a class="dropdown-item btn-command" href="/device/command/' . $data->id_sites . '" data-id="' . $data->id_sites . '" data-nama="' . $data->name_devices . '">Command</a>';
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
                  ' . $btn_command . '
                </div>
              </div>
          ';
      })
      ->addColumn('name_devices', function ($data) {
        return $data->name_devices;
      })
      ->addColumn('type', function ($data) {
        switch ($data->type) {
          case 'lamp':
            # code...
            return "Lampu";
            break;
          case 'humidifier':
            # code...
            return "Humidifier";
            break;
          case 'fan':
            # code...
            return "Fan";
            break;
          case 'door':
            # code...
            return "Door";
            break;
          case 'curtains':
            # code...
            return "Curtains";
            break;
          default:
            # code...
            return "Window";
            break;
        }
      })
      ->addIndexColumn() //increment
      ->make(true);
  }
}