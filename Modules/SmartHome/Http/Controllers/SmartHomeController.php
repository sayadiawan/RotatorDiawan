<?php

namespace Modules\SmartHome\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\SmartHome\Entities\SmartHome;
use Illuminate\Contracts\Support\Renderable;
use Modules\SmartHomeDevice\Entities\SmartHomeDevice;

class SmartHomeController extends Controller
{

  protected $firebase_premium;
  protected $database_premium;

  public function __construct()
  {
    $this->middleware('auth');
    $this->firebase_premium = (new Factory)->withServiceAccount(__DIR__ . '/DiawanSmartHome.json');
   $this->database_premium = $this->firebase_premium->withDatabaseUri('https://diawanpremium-smart-home-5758.asia-southeast1.firebasedatabase.app/')->createDatabase();
  }

  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index(Request $request)
  {
    $get_module = get_module_id('smarthome');


    if (Auth::user()->usergroup->code_usergroup == "SAS" || Auth::user()->usergroup->code_usergroup == "ADM") {
      $query = SmartHome::latest();
    } else {
      $query = SmartHome::latest()->where('users_id', Auth::user()->id);
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
    
    $result = $query->paginate(1)->withQueryString(); */

    $result = $query->whereHas('room', function ($query) {
      $query->whereNull('deleted_at');
    })
      ->filter(request(['search']))
      ->paginate(10)
      ->withQueryString();

    return view('smarthome::index', compact('get_module', 'result'));
  }

  public function rules($request)
  {
    $rule = [
      'rooms_id' => 'required',
      'users_id' => 'required',
    ];

    $pesan = [
      'rooms_id.required' => 'Room untuk smarthome wajib diisi!',
      'users_id.required' => 'User untuk smarthome wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('smarthome::create');
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
        $check = SmartHome::where('users_id', $request->users_id)
          ->where('rooms_id', $request->rooms_id)
          ->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Room untuk user yang dipilih sudah tersedia silahkan pilih yang lainnya!"], 200);
        } else {

          $post = new SmartHome();
          $post->users_id = $request->users_id;
          $post->rooms_id = $request->rooms_id;

          $simpan = $post->save();

          $value_firebase = [];
          $value_firebase["name"] = $post->room->name_rooms;
          $value_firebase["request"] = "-";

          $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/smarthomes/" . $post->id_smarthomes)->set(
            $value_firebase
          );

          DB::commit();

          if ($simpan == true) {
            return response()->json([
              'status' => true,
              'pesan' => "Data smart home berhasil disimpan!"
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'pesan' => "Data smart home tidak berhasil disimpan!"
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
    $data = SmartHome::find($id);
    return view('smarthome::show', compact('data'));
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $data = SmartHome::find($id);
    return view('smarthome::edit', compact('data'));
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
        $post = SmartHome::find($id);

        if ($post->rooms_id != $request->rooms_id || $post->users_id != $request->users_id) {
          $check = SmartHome::where('rooms_id', $request->rooms_id)
            ->where('users_id', $request->users_id)
            ->first();

          if ($check == null) {
            $post->rooms_id = $request->rooms_id;
            $post->users_id = $request->users_id;

            $value_firebase = [];
            $value_firebase["name"] = $post->room->name_rooms;

            $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/smarthomes/" . $post->id_smarthomes)->update(
              $value_firebase
            );
          } else {
            return response()->json(['status' => false, 'pesan' => 'Smart home user ' . $check->user->name . ' dan room ' . $check->room->name_rooms . ' telah tersedia. Silahkan gunakan user atau room lainnya.']);
          }
        }

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data smart home berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data smart home tidak berhasil disimpan!"
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
    $hapus = SmartHome::where('id_smarthomes', $id)->delete();

    $hapus_smarthome_device = SmartHomeDevice::where('smarthomes_id', $id)->delete();

    $this->database_premium->getReference("clients-smart-home/c8879e6e-db31-44e4-905e-ee87f238076a/client/c8879e6e-db31-44e4-905e-ee87f238076a/smarthomes/" . $id)->set(
      null
    );

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data smart home berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data smart home tidak berhasil dihapus!"], 400);
    }
  }
}