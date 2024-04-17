<?php

namespace Modules\SmartHomeDevice\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Ramsey\Uuid\Uuid;
use Illuminate\Routing\Controller;
use Modules\Site\Entities\Site;
use Illuminate\Support\Facades\Validator;
use Modules\SmartHome\Entities\SmartHome;
use Illuminate\Contracts\Support\Renderable;
use Modules\SmartHomeDevice\Entities\SmartHomeDevice;
use Illuminate\Support\Facades\DB;

use Modules\Site\Entities\DeviceAttributeValue;
use Modules\Site\Entities\DeviceAttributeType;

class SmartHomeDeviceController extends Controller
{

  protected $firebase_premium;
  protected $database_premium;

  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index(Request $request, $id_smarthome)
  {
    $get_module = get_module_id('smarthome');
    $item_smarthome = SmartHome::where('id_smarthomes', $id_smarthome)->first();

    $query = SmartHomeDevice::latest();
    $result = $query->whereHas('device', function ($query) {
      $query->whereNull('deleted_at');
    })
      ->where('smarthomes_id', $id_smarthome)
      ->filter(request(['search']))
      ->paginate(10)
      ->withQueryString();

    return view('smarthomedevice::index', compact('get_module', 'id_smarthome', 'item_smarthome', 'result'));
  }

  public function rules($request)
  {
    $rule = [
      'smarthome_device.*' => 'required'
    ];

    $pesan = [
      'smarthome_device.*.required' => 'Wajib memilih setidaknya satu device!'
    ];

    return Validator::make($request, $rule, $pesan);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create($id_smarthome)
  {
    $data_device = Site::orderBy('name_devices', 'asc')->get();
    $data_smarthome_device = SmartHomeDevice::where('smarthomes_id', $id_smarthome)->get();

    return view('smarthomedevice::create', compact('id_smarthome', 'data_device', 'data_smarthome_device'));
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
        $simpan = false;
        $check = false;

        // foreach
        if ($request->has('smarthome_device')) {
          $device_stored = array();

          foreach ($request->smarthome_device as $key => $value) {
            $check_user_device = SmartHomeDevice::where('smarthomes_id', $request->smarthomes_id)
              ->where('devices_id', $request->smarthome_device[$key])
              ->first();

            if ($check_user_device != null) {
              $check = true;

              array_push($device_stored, $check_user_device->device->name_devices);
            } else {
              $post = new SmartHomeDevice();
              $post->smarthomes_id = $request->smarthomes_id;
              $post->devices_id = $request->smarthome_device[$key];

              $simpan = $post->save();

              // dapatkan device command itu sednri 
              $device = Site::where('id_sites', $post->devices_id)->first();

              foreach ($device->devicecommand as $key => $value) {
                $value_firebase = [];
                $value_firebase["command"] = $value->command;
                $value_firebase["id_device"] = $post->devices_id;
                $value_firebase["value"] = $value->deviceatribute->code;

                $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/smarthomes/" . $post->smarthomes_id . "/request/" . $value->id_sites_command)->set(
                  $value_firebase
                );
              }
            }
          }

          if ($check == true) {

            $prefix = $check_list = '';

            foreach ($device_stored as $val) {
              $check_list .= $prefix . $val;
              $prefix = ', ';
            }

            return response()->json([
              'status' => false,
              'pesan' => "Data device " . $check_list . " untuk smart home sudah pernah diinputkan. Silahkan pilih device lainnya!"
            ], 200);
          }
        }

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data device untuk smart home berhasil disimpan!",
            'url_home' => route('smarthome.device.index', $request->smarthomes_id)
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data device untuk smart home tidak berhasil disimpan!"
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
    dd($id);
    return view('smarthomedevice::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    return view('smarthomedevice::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Renderable
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
  public function destroy($id)
  {
    $hapus = SmartHomeDevice::where('id_smarthome_devices', $id)->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data smart home untuk device berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data smart home untuk device tidak berhasil dihapus!"], 400);
    }
  }

  public function storeControlManual($id_smarthome, $id_device, Request $request)
  {
    DB::beginTransaction();

    try {
      // dd($request->all());

      $device=Site::findOrFail( $id_device);
      
      
 
      if(count($device->deviceattributevalue)>0){
        
        if(isset($request->device_control_switch)){
          
          $deviceAttributeValue= DeviceAttributeValue::where('device_id',$id_device)->where('device_attribute_type',"switch")->firstOrFail();
         
          if($deviceAttributeValue->device_attribute_type_val!= (string)$request->device_control_switch){
            
            if((string)$request->device_control_switch=="1"){
              
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/on")->set(
                1
              );
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/off")->set(
                0
              );
            }else{
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/off")->set(
                1
              );
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/on")->set(
                0
              );
              
            }

           

            
           
            $deviceAttributeValue->device_attribute_type_val =$request->device_control_switch;
            $deviceAttributeValue->save();
            DB::commit();
            
            

            
          }
        }
        if(isset($request->device_control_range)){
          $deviceAttributeValue= DeviceAttributeValue::where('device_id',$id_device)->where('device_attribute_type',"range")->firstOrFail();
         
          if($deviceAttributeValue->device_attribute_type_val!= (string)$request->device_control_range){
            
            if($device->type == "ac"){
              
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/suhu/value")->set(
                  1
                );
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/suhu/number")->set(
                  (int)$request->device_control_range
                );
            }else{
               $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/range/value")->set(
                  1
                );
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/range/number")->set(
                  (int)$request->device_control_range
                );
            }
            

            
            
            $deviceAttributeValue->device_attribute_type_val =$request->device_control_range;
            $deviceAttributeValue->save();
            DB::commit();
            


          }
        }
        if(isset($request->device_control_lock)){
          
          $deviceAttributeValue= DeviceAttributeValue::where('device_id',$id_device)->where('device_attribute_type',"lock")->firstOrFail();
          if($deviceAttributeValue->device_attribute_type_val!= (string)$request->device_control_lock){
            $deviceAttributeValue->device_attribute_type_val =$request->device_control_lock;
            $deviceAttributeValue->save();
            DB::commit();

            if((string)$request->device_control_lock=="1"){
              
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/lock")->set(
                1
              );
               $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/unlocked")->set(
                0
              );
            }else{
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/unlocked")->set(
                1
              );
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/lock")->set(
                0
              );
            }

          }
        }

        if(isset($request->device_control_color)){
          $deviceAttributeValue= DeviceAttributeValue::where('device_id',$id_device)->where('device_attribute_type',"color")->firstOrFail();
         
          if($deviceAttributeValue->device_attribute_type_val!=json_encode($request->device_control_color)){
            $deviceAttributeValue->device_attribute_type_val =json_encode($request->device_control_color);
            $deviceAttributeValue->save();
            DB::commit();
            
            $value_firebase = [];
            $value_firebase["red"] = $request->device_control_color[0];
            $value_firebase["green"] = $request->device_control_color[1];
            $value_firebase["blue"] = $request->device_control_color[2];
            $value_firebase["value"] = 1;
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/color")->set(
                $value_firebase
              );
            

          }
        }

        if(isset($request->device_control_mode)){
          $deviceAttributeValue= DeviceAttributeValue::where('device_id',$id_device)->where('device_attribute_type',"mode")->firstOrFail();
        
          if($deviceAttributeValue->device_attribute_type_val!= (string)$request->device_control_mode){
            
            $deviceAttributeValue->device_attribute_type_val =$request->device_control_mode;
            $deviceAttributeValue->save();
            DB::commit();

              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/mode/value")->set(
                  1
                );
              $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/".$device->client_id."/devices/".$id_device."/value/mode/number")->set(
                  (int)$request->device_control_mode
                );

          }
        }
        if(isset($request->device_control_motion)){
          $deviceAttributeValue= DeviceAttributeValue::where('device_id',$id_device)->where('device_attribute_type',"motion")->firstOrFail();
         
          if($deviceAttributeValue->device_attribute_type_val!= (string)$request->device_control_motion){
            $deviceAttributeValue->device_attribute_type_val =$request->device_control_motion;
            $deviceAttributeValue->save();
            DB::commit();

          }
        }
        
        
      }else{
        // dd(($request->device_control_color));
        if(isset($request->device_control_switch)){
         
          $deviceAttributeValue=new DeviceAttributeValue;
          $uuid4 = Uuid::uuid4();
          $deviceAttributeValue->id_device_attribute_value=$uuid4;
          $deviceAttributeValue->device_attribute_type_id= $device->deviceattributetype->id_device_attribute_type;
          $deviceAttributeValue->device_id=$id_device;
      
          $deviceAttributeValue->device_attribute_type_val =$request->device_control_switch;
          $deviceAttributeValue->device_attribute_type="switch";
      
          $deviceAttributeValue->save();
          DB::commit();

        }
        if(isset($request->device_control_range)){
          $deviceAttributeValue=new DeviceAttributeValue;
          $uuid4 = Uuid::uuid4();
          $deviceAttributeValue->id_device_attribute_value=$uuid4;
          $deviceAttributeValue->device_attribute_type_id= $device->deviceattributetype->id_device_attribute_type;
          $deviceAttributeValue->device_id=$id_device;
          $deviceAttributeValue->device_attribute_type_val =$request->device_control_range;
          $deviceAttributeValue->device_attribute_type="range";
          $deviceAttributeValue->save();
          DB::commit();

        }
        if(isset($request->device_control_lock)){
          $deviceAttributeValue=new DeviceAttributeValue;
          $uuid4 = Uuid::uuid4();
          $deviceAttributeValue->id_device_attribute_value=$uuid4;
          $deviceAttributeValue->device_attribute_type_id= $device->deviceattributetype->id_device_attribute_type;
          $deviceAttributeValue->device_id=$id_device;
           $deviceAttributeValue->device_attribute_type ="lock";
           $deviceAttributeValue->device_attribute_type_val=$request->device_control_lock;
           $deviceAttributeValue->save();
          DB::commit();

        }

        if(isset($request->device_control_color)){
          $deviceAttributeValue=new DeviceAttributeValue;
          $uuid4 = Uuid::uuid4();
          $deviceAttributeValue->id_device_attribute_value=$uuid4;
          $deviceAttributeValue->device_attribute_type_id= $device->deviceattributetype->id_device_attribute_type;
          $deviceAttributeValue->device_id=$id_device;
           $deviceAttributeValue->device_attribute_type_val =json_encode($request->device_control_color);
           $deviceAttributeValue->device_attribute_type="color";
           $deviceAttributeValue->save();
          DB::commit();

        }

        if(isset($request->device_control_mode)){
          $deviceAttributeValue=new DeviceAttributeValue;
          $uuid4 = Uuid::uuid4();
          $deviceAttributeValue->id_device_attribute_value=$uuid4;
          $deviceAttributeValue->device_attribute_type_id= $device->deviceattributetype->id_device_attribute_type;
          $deviceAttributeValue->device_id=$id_device;
          $deviceAttributeValue->device_attribute_type_val =$request->device_control_mode;
           $deviceAttributeValue->device_attribute_type="mode";
           $deviceAttributeValue->save();
          DB::commit();

        }
        if(isset($request->device_control_motion)){
          $deviceAttributeValue=new DeviceAttributeValue;
          $uuid4 = Uuid::uuid4();
          $deviceAttributeValue->id_device_attribute_value=$uuid4;
          $deviceAttributeValue->device_attribute_type_id= $device->deviceattributetype->id_device_attribute_type;
          $deviceAttributeValue->device_id=$id_device;
           $deviceAttributeValue->device_attribute_type_val =$request->device_control_motion;
           $deviceAttributeValue->device_attribute_type="motion";
           $deviceAttributeValue->save();
          DB::commit();

        }
        
      }
      return response()->json(['status' => true], 200);
    } catch (\Exception $e) {
      DB::rollback();

      return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
    }
  }
}