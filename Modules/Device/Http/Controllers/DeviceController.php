<?php

namespace Modules\Device\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Modules\Icon\Entities\Icon;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Device\Entities\Device;
use Illuminate\Support\Facades\Validator;
use Modules\Device\Entities\DeviceCommand;
use Illuminate\Contracts\Support\Renderable;
use Modules\Device\Entities\DeviceAttribute;
use Modules\Device\Entities\DeviceAttributeType;
use Modules\Device\Entities\DeviceAttributeTypeLock;
use Modules\Device\Entities\DeviceAttributeTypeMode;
use Modules\Device\Entities\DeviceAttributeTypeColor;
use Modules\Device\Entities\DeviceAttributeTypeMonitoring;
use Modules\Device\Entities\DeviceAttributeTypeRange;
use Modules\Device\Entities\DeviceAttributeTypeMotion;
use Modules\Device\Entities\DeviceAttributeTypeSwitch;








class DeviceController extends Controller
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

    $this->firebase_premium = (new Factory)->withServiceAccount(__DIR__ . '/DiawanSmartHome.json');
   $this->database_premium = $this->firebase_premium->withDatabaseUri('https://diawanpremium-smart-home-5758.asia-southeast1.firebasedatabase.app/')->createDatabase();
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

  public function edit_rules($request)
  {
    $rule = [
      'name_devices' => 'required',
      'alias_devices' => 'required',


    ];
    $pesan = [
      'name_devices.required' => 'Nama Device Wajib di isi',
      'alias_devices.required' => 'Nama alias device wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  public function index(Request $request)
  {
    if (request()->ajax()) {
      $datas = Device::select(['id_devices', 'name_devices', 'type', 'created_at'])
        ->orderBy('created_at', 'DESC')
        ->get();

      return Datatables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name_devices']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['type']), Str::lower($request->get('search')))) {
                return true;
              }

              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_module = get_module_id('device');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_module, auth()->user()->roles)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('device.show', $data->id_devices) . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_module, auth()->user()->roles)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('device.edit', $data->id_devices) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_module, auth()->user()->roles)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id_devices . '" data-nama="' . $data->name_devices . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          }

          $btn_command = '';
          if (isAccess('command', $id_module, auth()->user()->roles)) {
            $btn_command = '<a class="dropdown-item btn-command" href="/device/command/' . $data->id_devices . '" data-id="' . $data->id_devices . '" data-nama="' . $data->name_devices . '"><i class="fas fa-microphone"></i>  Command</a>';
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
            case 'ac':
              # code...
              return "AC (Air Conditioner)";
              break;
            case 'cctv':
              # code...
              return "CCTV (Closed Circuit Television)";
              break;
            default:
              # code...
              return "Window";
              break;
          }
        })
        ->rawColumns(['action', 'type'])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $devices = Device::all();
    $get_module = get_module_id('device');

    return view('device::index', compact('devices', 'get_module'));
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
        $id_devices = [];

        $device = new Device();
        $device->name_devices = $request->post('name_devices');
        $device->alias_devices = $request->post('alias_devices');
        $device->type = $request->post('type');
        $device->icons_id = $request->post('icons');
        $device->client_id = "c8879e6e-db31-44e4-905e-ee87f238076a";
        $simpan = $device->save();

        $value_firebase["alias"] = $request->post('alias_devices');
        $value_firebase["value"] = [];
        $value_firebase["value"]["on"] = 0;
        $value_firebase["value"]["off"] = 0;
        $value_firebase["value"]["suhu"] = [];
        $value_firebase["value"]["suhu"]["value"] = 0;
        $value_firebase["value"]["suhu"]["value"] = 0;


        $id_devices["alias"] = $request->post('alias_devices');
        // kodisi jika user memilih tipe device lampu
        $deviceAttributeType = new DeviceAttributeType();
        $deviceAttributeType->device_id = $device->id_devices;

        $deviceAttributeType->is_switch_device_attribute_type = $request->has('is_switch_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_switch_device_attribute_type = $request->has('is_switch_device_attribute_type') == true ? $request->label_switch_device_attribute_type : null;

        $deviceAttributeType->is_range_device_attribute_type = $request->has('is_range_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_range_device_attribute_type = $request->has('is_range_device_attribute_type') == true ? $request->label_range_device_attribute_type : null;

        $deviceAttributeType->is_color_device_attribute_type = $request->has('is_color_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_color_device_attribute_type = $request->has('is_color_device_attribute_type') == true ? $request->label_color_device_attribute_type : null;

        $deviceAttributeType->is_mode_device_attribute_type = $request->has('is_mode_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_mode_device_attribute_type = $request->has('is_mode_device_attribute_type') == true ? $request->label_mode_device_attribute_type : null;

        $deviceAttributeType->is_motion_device_attribute_type = $request->has('is_motion_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_motion_device_attribute_type = $request->has('is_motion_device_attribute_type') == true ? $request->label_motion_device_attribute_type : null;

        $deviceAttributeType->is_lock_device_attribute_type = $request->has('is_lock_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_lock_device_attribute_type = $request->has('is_lock_device_attribute_type') == true ? $request->label_lock_device_attribute_type : null;

        $deviceAttributeType->is_monitoring_device_attribute_type = $request->has('is_monitoring_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_monitoring_device_attribute_type = $request->has('is_monitoring_device_attribute_type') == true ? $request->label_monitoring_device_attribute_type : null;

        $deviceAttributeType->save();

        // kondisi jika user memilih attribute switch 
        if ($request->has('is_switch_device_attribute_type') == true) {
          $deviceAttributeTypeSwitch = new DeviceAttributeTypeSwitch();
          $deviceAttributeTypeSwitch->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
          $deviceAttributeTypeSwitch->on_txt_device_attribute_type_switch = $request->on_txt_device_attribute_type_switch ?? 'Menyala';
          $deviceAttributeTypeSwitch->off_txt_device_attribute_type_switch = $request->off_txt_device_attribute_type_switch ?? 'Mati';

          $deviceAttributeTypeSwitch->save();
        }

        // kondisi jika user memilih attribute range
        if ($request->has('is_range_device_attribute_type') == true) {
          $deviceAttributeTypeRange = new DeviceAttributeTypeRange();
          $deviceAttributeTypeRange->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
          $deviceAttributeTypeRange->min_device_attribute_type_range = $request->min_device_attribute_type_range ?? '0';
          $deviceAttributeTypeRange->max_device_attribute_type_range = $request->max_device_attribute_type_range ?? '1';

          $deviceAttributeTypeRange->save();
        }

        // kondisi jika user memilih attribute color
        if ($request->has('is_color_device_attribute_type') == true) {
          $deviceAttributeTypeColor = new DeviceAttributeTypeColor();
          $deviceAttributeTypeColor->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;

          $deviceAttributeTypeColor->save();
        }

        // kondisi jika user memilih attribute mode
        if ($request->has('is_mode_device_attribute_type') == true) {
          // check dulu apakah user mengisi field mode 
          if (isset($request->name_device_attribute_type_mode)) {
            for ($i = 0; $i < count($request->name_device_attribute_type_mode); $i++) {
              $deviceAttributeTypeMode = new DeviceAttributeTypeMode();
              $deviceAttributeTypeMode->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
              $deviceAttributeTypeMode->name_device_attribute_type_mode = $request->name_device_attribute_type_mode[$i];
              $deviceAttributeTypeMode->value_device_attribute_type_mode = $request->value_device_attribute_type_mode[$i];

              $deviceAttributeTypeMode->save();
            }
          }
        }

        // kondisi jika user memilih attribute motion
        if ($request->has('is_motion_device_attribute_type') == true) {
          $deviceAttributeTypeMotion = new DeviceAttributeTypeMotion();
          $deviceAttributeTypeMotion->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
          $deviceAttributeTypeSwitch->on_txt_device_attribute_type_motion = $request->on_txt_device_attribute_type_motion ?? 'Gerak';
          $deviceAttributeTypeSwitch->off_txt_device_attribute_type_motion = $request->off_txt_device_attribute_type_motion ?? 'Mati';

          $deviceAttributeTypeMotion->save();
        }

        // kondisi jika user memilih attribute lock
        if ($request->has('is_lock_device_attribute_type') == true) {
          $deviceAttributeTypeLock = new DeviceAttributeTypeLock();
          $deviceAttributeTypeLock->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
          $deviceAttributeTypeLock->on_txt_device_attribute_type_lock = $request->on_txt_device_attribute_type_lock ?? 'Membuka';
          $deviceAttributeTypeLock->off_txt_device_attribute_type_lock = $request->off_txt_device_attribute_type_lock ?? 'Menutup';

          $deviceAttributeTypeLock->save();
        }

        // kondisi jika user memilih attribute monitoring
        if ($request->has('is_monitoring_device_attribute_type') == true) {
          $deviceAttributeTypeMonitoring = new DeviceAttributeTypeMonitoring();
          $deviceAttributeTypeMonitoring->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;

          $deviceAttributeTypeMonitoring->save();
        }

        $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/devices/" . $device->id_devices)->update(
          $value_firebase
        );

        if ($request->post('type') == "ac") {
          $device_atribute = DeviceAttribute::where("code", "suhu-val-")->first();
          $deviceCommand = new DeviceCommand();
          $deviceCommand->device_atribute_id = $device_atribute->id_device_atribute;
          $deviceCommand->device_id = $device->id_devices;
          $deviceCommand->command = "suhu ";
          $deviceCommand->command_is_ori = 1;
          $deviceCommand->val = $device_atribute->code;
          $save = $deviceCommand->save();
          $command["command"] = "suhu ";
          $command["id_device"] = $device->id_devices;
          $command["value"] = $device_atribute->code;

          $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/devices/" . $device->id_devices . "/request/" . $deviceCommand->id_devices_command)->set(
            $command
          );

          $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/request/" . $deviceCommand->id_devices_command)->set(
            $command
          );
        }

        $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/id_devices/" . $device->id_devices)->update(
          $id_devices
        );

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

  public function set_command(Request $request, $id)
  {
    $id = $request->id;
    $device_atribute = DeviceAttribute::find($request->post('type'));
    $value_firebase = [];
    $device = Device::find($id);
    $deviceCommand = new DeviceCommand();
    $deviceCommand->device_atribute_id = $request->post('type');
    $deviceCommand->device_id = $id;
    $deviceCommand->command_is_ori = 0;
    $deviceCommand->command = $request->post('voice_command');
    $deviceCommand->val = $device_atribute->code;
    $save = $deviceCommand->save();
    $value_firebase["command"] = $request->post('voice_command');
    $value_firebase["id_device"] = $id;
    $value_firebase["value"] = $device_atribute->code;

    $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/devices/" . $device->id_devices . "/request/" . $deviceCommand->id_devices_command)->set(
      $value_firebase
    );

    $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/request/" . $deviceCommand->id_devices_command)->set(
      $value_firebase
    );


    foreach ($device->smarthomedevice as $key => $value) {
      $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/smarthomes/" . $value->smarthome->id_smarthomes . "/request/" . $deviceCommand->id_devices_command)->set(
        $value_firebase
      );
    }

    $set_url = url('/device/command', $id);


    if ($save == true) {
      return response()->json(['status' => true, 'pesan' => "Data Command berhasil ditambahkan!", 'set_url' => $set_url], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data Command tidak berhasil ditambahkan!"], 400);
    }
  }

  public function command($id)
  {
    $data = Device::find($id);


    $code = '
            //Client ID
            String clientId = "c8879e6e-db31-44e4-905e-ee87f238076a";
            //User ID
            String userId = "c8879e6e-db31-44e4-905e-ee87f238076a";
            //ID Device
            String idDevice = "' . $id . '";
            ';
    return view('device::command', ['get_data' => $data, 'code' => $code]);
  }

  public function command_destroy(Request $request)
  {
    $id = $request->id;
    $query = DeviceCommand::find($id);




    $device = $query->device;
    // dd($device ->smartHomeDevice);

    $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/request/" . $query->id_devices_command)->set(
      null
    );
    $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/devices/" . $device->id_devices . "/request/" . $query->id_devices_command)->set(
      null
    );
    foreach ($device->smartHomeDevice as $smartHomeDevice) {
      $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/smarthomes/" . $smartHomeDevice->smarthomes_id . "/request/" . $query->id_devices_command)->set(
        null
      );
    }

    // final step hapus device (indukan)
    $hapus = $query->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data Command berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data Command tidak berhasil dihapus!"], 400);
    }
  }

  public function show($id)
  {
    $data = Device::find($id);
    $code = '
            //Client ID
            String clientId = "c8879e6e-db31-44e4-905e-ee87f238076a";
            //User ID
            String userId = "c8879e6e-db31-44e4-905e-ee87f238076a";
            //ID Device
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
    $device = Device::find($id);
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

        $device = Device::findOrFail($id);
        $device->name_devices = $request->post('name_devices');
        $device->alias_devices = $request->post('alias_devices');
        $device->type = $request->post('type');
        $device->icons_id = $request->post('icons');
        $simpan = $device->save();

        $value_firebase["alias"] = $request->post('name_devices');
        $value_firebase["value"] = "-";

        // kodisi jika user memilih tipe device lampu
        $deviceAttributeType = DeviceAttributeType::where('device_id', $id)->first();
        $deviceAttributeType->device_id = $device->id_devices;

        $deviceAttributeType->is_switch_device_attribute_type = $request->has('is_switch_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_switch_device_attribute_type = $request->has('is_switch_device_attribute_type') == true ? $request->label_switch_device_attribute_type : null;

        $deviceAttributeType->is_range_device_attribute_type = $request->has('is_range_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_range_device_attribute_type = $request->has('is_range_device_attribute_type') == true ? $request->label_range_device_attribute_type : null;

        $deviceAttributeType->is_color_device_attribute_type = $request->has('is_color_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_color_device_attribute_type = $request->has('is_color_device_attribute_type') == true ? $request->label_color_device_attribute_type : null;

        $deviceAttributeType->is_mode_device_attribute_type = $request->has('is_mode_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_mode_device_attribute_type = $request->has('is_mode_device_attribute_type') == true ? $request->label_mode_device_attribute_type : null;

        $deviceAttributeType->is_motion_device_attribute_type = $request->has('is_motion_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_motion_device_attribute_type = $request->has('is_motion_device_attribute_type') == true ? $request->label_motion_device_attribute_type : null;

        $deviceAttributeType->is_lock_device_attribute_type = $request->has('is_lock_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_lock_device_attribute_type = $request->has('is_lock_device_attribute_type') == true ? $request->label_lock_device_attribute_type : null;

        $deviceAttributeType->is_monitoring_device_attribute_type = $request->has('is_monitoring_device_attribute_type') == true ? '1' : '0';
        $deviceAttributeType->label_monitoring_device_attribute_type = $request->has('is_monitoring_device_attribute_type') == true ? $request->label_monitoring_device_attribute_type : null;

        $deviceAttributeType->save();

        // kondisi jika user memilih attribute switch 
        if ($request->has('is_switch_device_attribute_type') == true) {
          // check dulu apakah sudah pernah dibuat atau belum 
          $checkDeviceAttributeTypeSwitch = DeviceAttributeTypeSwitch::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();

          // jika belum maka create new 
          if ($checkDeviceAttributeTypeSwitch != null) {
            $deviceAttributeTypeSwitch = DeviceAttributeTypeSwitch::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();
            $deviceAttributeTypeSwitch->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
            $deviceAttributeTypeSwitch->on_txt_device_attribute_type_switch = $request->on_txt_device_attribute_type_switch ?? 'Menyala';
            $deviceAttributeTypeSwitch->off_txt_device_attribute_type_switch = $request->off_txt_device_attribute_type_switch ?? 'Mati';
          } else {
            $deviceAttributeTypeSwitch = new DeviceAttributeTypeSwitch();
            $deviceAttributeTypeSwitch->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
            $deviceAttributeTypeSwitch->on_txt_device_attribute_type_switch = $request->on_txt_device_attribute_type_switch ?? 'Menyala';
            $deviceAttributeTypeSwitch->off_txt_device_attribute_type_switch = $request->off_txt_device_attribute_type_switch ?? 'Mati';
          }


          $deviceAttributeTypeSwitch->save();
        } else {
          // hapus beberapa attribute yang pernah kepilih lalu diganti dengan yang lain 
          // 1. hapus switch
          DeviceAttributeTypeSwitch::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();
        }

        // kondisi jika user memilih attribute range 
        if ($request->has('is_range_device_attribute_type') == true) {
          // check dulu apakah sudah pernah dibuat atau belum 
          $checkDeviceAttributeTypeRange = DeviceAttributeTypeRange::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();

          // jika belum maka create new 
          if ($checkDeviceAttributeTypeRange != null) {
            $deviceAttributeTypeRange = DeviceAttributeTypeRange::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();
            $deviceAttributeTypeRange->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
            $deviceAttributeTypeRange->min_device_attribute_type_range = $request->min_device_attribute_type_range ?? '0';
            $deviceAttributeTypeRange->max_device_attribute_type_range = $request->max_device_attribute_type_range ?? '1';
          } else {
            $deviceAttributeTypeRange = new DeviceAttributeTypeRange();
            $deviceAttributeTypeRange->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
            $deviceAttributeTypeRange->min_device_attribute_type_range = $request->min_device_attribute_type_range ?? '0';
            $deviceAttributeTypeRange->max_device_attribute_type_range = $request->max_device_attribute_type_range ?? '1';
          }


          $deviceAttributeTypeRange->save();
        } else {
          // hapus beberapa attribute yang pernah kepilih lalu diganti dengan yang lain 
          // 1. hapus range
          DeviceAttributeTypeRange::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();
        }

        // kondisi jika user memilih attribute color 
        if ($request->has('is_color_device_attribute_type') == true) {
          // check dulu apakah sudah pernah dibuat atau belum 
          $checkDeviceAttributeTypeColor = DeviceAttributeTypeColor::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();

          // jika belum maka create new 
          if ($checkDeviceAttributeTypeColor != null) {
            $deviceAttributeTypeColor = DeviceAttributeTypeColor::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();
            $deviceAttributeTypeColor->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
          } else {
            $deviceAttributeTypeColor = new DeviceAttributeTypeColor();
            $deviceAttributeTypeColor->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
          }


          $deviceAttributeTypeColor->save();
        } else {
          // hapus beberapa attribute yang pernah kepilih lalu diganti dengan yang lain 
          // 1. hapus color
          DeviceAttributeTypeColor::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();
        }

        // kondisi jika user memilih attribute mode 
        if ($request->has('is_mode_device_attribute_type') == true) {
          // check dulu apakah sudah pernah dibuat atau belum
          $checkDeviceAttributeTypeMode = DeviceAttributeTypeMode::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->get();

          // jika belum maka create new 
          if (count($checkDeviceAttributeTypeMode) > 0) {
            DeviceAttributeTypeMode::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();

            // check dulu apakah user mengisi field mode 
            if (isset($request->name_device_attribute_type_mode)) {
              for ($i = 0; $i < count($request->name_device_attribute_type_mode); $i++) {
                $deviceAttributeTypeMode = new DeviceAttributeTypeMode();
                $deviceAttributeTypeMode->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
                $deviceAttributeTypeMode->name_device_attribute_type_mode = $request->name_device_attribute_type_mode[$i];
                $deviceAttributeTypeMode->value_device_attribute_type_mode = $request->value_device_attribute_type_mode[$i];

                $deviceAttributeTypeMode->save();
              }
            }
          } else {
            // check dulu apakah user mengisi field mode 
            if (isset($request->name_device_attribute_type_mode)) {
              for ($i = 0; $i < count($request->name_device_attribute_type_mode); $i++) {
                $deviceAttributeTypeMode = new DeviceAttributeTypeMode();
                $deviceAttributeTypeMode->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
                $deviceAttributeTypeMode->name_device_attribute_type_mode = $request->name_device_attribute_type_mode[$i];
                $deviceAttributeTypeMode->value_device_attribute_type_mode = $request->value_device_attribute_type_mode[$i];

                $deviceAttributeTypeMode->save();
              }
            }
          }
        } else {
          // hapus beberapa attribute yang pernah kepilih lalu diganti dengan yang lain 
          // 1. hapus mode
          DeviceAttributeTypeMode::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();
        }

        // kondisi jika user memilih attribute motion 
        if ($request->has('is_motion_device_attribute_type') == true) {
          // check dulu apakah sudah pernah dibuat atau belum 
          $checkDeviceAttributeTypeMotion = DeviceAttributeTypeMotion::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();

          // jika belum maka create new 
          if ($checkDeviceAttributeTypeMotion != null) {
            $deviceAttributeTypeMotion = DeviceAttributeTypeMotion::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();
            $deviceAttributeTypeMotion->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
            $deviceAttributeTypeMotion->on_txt_device_attribute_type_motion = $request->on_txt_device_attribute_type_motion ?? 'Gerak';
            $deviceAttributeTypeMotion->off_txt_device_attribute_type_motion = $request->off_txt_device_attribute_type_motion ?? 'Mati';
          } else {
            $deviceAttributeTypeMotion = new DeviceAttributeTypeMotion();
            $deviceAttributeTypeMotion->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
            $deviceAttributeTypeMotion->on_txt_device_attribute_type_motion = $request->on_txt_device_attribute_type_motion ?? 'Gerak';
            $deviceAttributeTypeMotion->off_txt_device_attribute_type_motion = $request->off_txt_device_attribute_type_motion ?? 'Mati';
          }


          $deviceAttributeTypeMotion->save();
        } else {
          // hapus beberapa attribute yang pernah kepilih lalu diganti dengan yang lain 
          // 1. hapus motion
          DeviceAttributeTypeMotion::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();
        }

        // kondisi jika user memilih attribute lock 
        if ($request->has('is_lock_device_attribute_type') == true) {
          // check dulu apakah sudah pernah dibuat atau belum 
          $checkDeviceAttributeTypeLock = DeviceAttributeTypeLock::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();

          // jika belum maka create new 
          if ($checkDeviceAttributeTypeLock != null) {
            $deviceAttributeTypeLock = DeviceAttributeTypeLock::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();
            $deviceAttributeTypeLock->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
            $deviceAttributeTypeLock->on_txt_device_attribute_type_lock = $request->on_txt_device_attribute_type_lock ?? 'Gerak';
            $deviceAttributeTypeLock->off_txt_device_attribute_type_lock = $request->off_txt_device_attribute_type_lock ?? 'Mati';
          } else {
            $deviceAttributeTypeLock = new DeviceAttributeTypeLock();
            $deviceAttributeTypeLock->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
            $deviceAttributeTypeLock->on_txt_device_attribute_type_lock = $request->on_txt_device_attribute_type_lock ?? 'Gerak';
            $deviceAttributeTypeLock->off_txt_device_attribute_type_lock = $request->off_txt_device_attribute_type_lock ?? 'Mati';
          }


          $deviceAttributeTypeLock->save();
        } else {
          // hapus beberapa attribute yang pernah kepilih lalu diganti dengan yang lain 
          // 1. hapus lock
          DeviceAttributeTypeLock::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();
        }

        // kondisi jika user memilih attribute monitoring 
        if ($request->has('is_monitoring_device_attribute_type') == true) {
          // check dulu apakah sudah pernah dibuat atau belum 
          $checkDeviceAttributeTypeMonitoring = DeviceAttributeTypeMonitoring::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();

          // jika belum maka create new 
          if ($checkDeviceAttributeTypeMonitoring != null) {
            $deviceAttributeTypeMonitoring = DeviceAttributeTypeMonitoring::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->first();
            $deviceAttributeTypeMonitoring->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
          } else {
            $deviceAttributeTypeMonitoring = new DeviceAttributeTypeMonitoring();
            $deviceAttributeTypeMonitoring->device_attribute_type_id = $deviceAttributeType->id_device_attribute_type;
          }


          $deviceAttributeTypeMonitoring->save();
        } else {
          // hapus beberapa attribute yang pernah kepilih lalu diganti dengan yang lain 
          // 1. hapus lock
          DeviceAttributeTypeMonitoring::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();
        }

        $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/devices/" . $device->id_devices)->update(
          $value_firebase
        );

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
    $query = Device::where('id_devices', $id);

    $device = $query->first();

    $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/devices/" . $id)->set(
      null
    );

    $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/id_devices/" . $id)->set(
      null
    );

    $commands = $device->devicecommand;
    $smarthomedevices = $device->smarthomedevice;

    foreach ($commands as $command) {
      $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/request/" . $command->id_devices_command)->set(
        null
      );
      foreach ($smarthomedevices as $smarthomedevice) {
        $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/" . $device->client_id . "/smarthomes/" . $smarthomedevice->smarthomes_id . "/request/" . $command->id_devices_command)->set(
          null
        );
      }
    }

    // Hapus device attribute lamp
    $query_attribute_type = DeviceAttributeType::where('device_id', $id);

    // Hapus device attribute lamp switc, range, mode, color 
    $deviceAttributeType = $query_attribute_type->first();

    DeviceAttributeTypeSwitch::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();

    DeviceAttributeTypeRange::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();

    DeviceAttributeTypeColor::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();

    DeviceAttributeTypeMode::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();

    DeviceAttributeTypeMotion::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();

    DeviceAttributeTypeLock::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();

    DeviceAttributeTypeMonitoring::where('device_attribute_type_id', $deviceAttributeType->id_device_attribute_type)->delete();

    // final step untuk hapus device attribute lamp
    $query_attribute_type->delete($id);

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
    $datas = Device::select(['id_devices', 'name_devices', 'type', 'created_at']);

    return Datatables::of($datas)
      ->addColumn('action', function ($data) {

        //get module akses
        $id_module = get_module_id('device');

        //detail
        $btn_detail = '';
        if (isAccess('detail', $id_module, auth()->user()->roles)) {
          $btn_detail = '<a class="dropdown-item" href="' . route('device.show', $data->id_devices) . '">Detail</a>';
        }

        //edit
        $btn_edit = '';
        if (isAccess('update', $id_module, auth()->user()->roles)) {
          $btn_edit = ' <button type="button" onclick="location.href=' . "'" . route('device.edit', $data->id_devices) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
        }

        //delete
        $btn_hapus = '';
        if (isAccess('delete', $id_module, auth()->user()->roles)) {
          $btn_hapus = '<a class="dropdown-item btn-hapus" href="#hapus" data-id="' . $data->id_devices . '" data-nama="' . $data->name_devices . '">Hapus</a>';
        }

        $btn_command = '';
        if (isAccess('command', $id_module, auth()->user()->roles)) {
          $btn_command = '<a class="dropdown-item btn-command" href="/device/command/' . $data->id_devices . '" data-id="' . $data->id_devices . '" data-nama="' . $data->name_devices . '">Command</a>';
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