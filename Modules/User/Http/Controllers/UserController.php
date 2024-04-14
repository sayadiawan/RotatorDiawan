<?php

namespace Modules\User\Http\Controllers;

use PDF;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\Division;
use Modules\User\Entities\Position;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Employee\Entities\Employee;
use Modules\Position\Entities\Positions;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Modules\Privileges\Entities\Privilege;
use Illuminate\Contracts\Support\Renderable;

class UserController extends Controller
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
      $datas = User::orderBy('created_at', 'DESC')->get();

      return Datatables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['username']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['phone']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['set_role']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['set_status']), Str::lower($request->get('search')))) {
                return true;
              }

              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_module = get_module_id('user');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_module, auth()->user()->roles)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('user.show', $data->id) . '"><i class="fas fa-info me-1"></i> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_module, auth()->user()->roles)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('user.edit', $data->id) . '"><i class="fas fa-pencil-alt me-1"></i> Edit</a>';
          }

          //delete
          $btn_hapus = '';
          if (isAccess('delete', $id_module, auth()->user()->roles)) {
            $btn_hapus = '<a class="dropdown-item btn-hapus" href="javascript:void(0)" data-id="' . $data->id . '" data-nama="' . $data->name . '"><i class="fas fa-trash-alt me-1"></i> Hapus</a>';
          }

          //reset passwrod
          $btn_reset = '';
          if (isAccess('reset', $id_module, auth()->user()->roles)) {
            $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $data->id . '" data-nama="' . $data->nama . '"><i class="fas fa-undo-alt me-1"></i> Reset Password</a>';
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
                  ' . $btn_reset . '
                </div>
              </div>
          ';
        })
        ->addColumn('set_status', function ($data) {
          if ($data->status == "1") {
            $btn = "success";
            $status = "Aktif";
          } else {
            $btn = "warning";
            $status = "Tidak Aktif";
          }
          $set_status = '<button type="button" class="btn btn-sm btn-' . $btn . ' btn-status" data-val="' . $data->status . '" data-id="' . $data->id . '" data-nama="' . $data->nama . '">' . $status . '</button>';

          return $set_status;
        })
        ->addColumn('set_role', function ($data) {
          return $data->privileges->name_usergroup ?? "";
        })
        ->rawColumns(['action', 'set_status', 'set_role'])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $get_module = get_module_id('user');
    return view('user::index', compact('get_module'));
  }

  public function rules($request)
  {
    $rule = [
      'name' => 'required|string|max:100',
      'username' => 'required|string',
      'email' => 'required|email',
      'phone' => 'required|numeric|digits_between:10,12',
      'roles' => 'required',
      'status' => 'required',
    ];
    $pesan = [
      'name.required' => 'Nama pengguna wajib diisi!',
      'username.required' => 'Username wajib diisi!',
      'email.required' => 'Email pengguna wajib diisi!',
      'phone.required' => 'Nomor telepon pengguna wajib diisi!',
      'roles.required' => 'Hak akses wajib diisi!',
      'status.required' => 'Status akun wajib diisi!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    $role = Privilege::orderBy('name_usergroup')->get();
    $pegawai = Employee::orderBy('name_employee')->get();

    return view('user::create', compact('pegawai', 'role'));
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
        $check = User::where('username', $request->username)
          ->first();

        if ($check != null) {
          return response()->json(['status' => false, 'pesan' => "Username sudah tersedia silahkan gunakan username yang berbeda!"], 200);
        } else {
          $post = new User();
          $post->name = $request->name;
          $post->username = $request->post('username');
          $post->email = $request->post('email');
          $post->phone = $request->post('phone');
          $post->roles = $request->post('roles');
          $post->status = $request->post('status');
          $post->password = Hash::make('diawansmarthome');

          $simpan = $post->save();

          DB::commit();

          if ($simpan == true) {
            return response()->json([
              'status' => true,
              'pesan' => "Data pengguna berhasil disimpan!"
            ], 200);
          } else {
            return response()->json([
              'status' => false,
              'pesan' => "Data pengguna tidak berhasil disimpan!"
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
    $data = User::find($id);
    $pegawai = Employee::orderBy('name_employee')->get();
    $role = Privilege::orderBy('name_usergroup')->get();
    return view('user::show', ['get_data' => $data, 'pegawai' => $pegawai, 'role' => $role]);
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $data = User::find($id);
    $pegawai = Employee::orderBy('name_employee')->get();
    $role = Privilege::orderBy('name_usergroup')->get();
    return view('user::edit', ['get_data' => $data, 'pegawai' => $pegawai, 'role' => $role]);
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
        $post = User::find($id);

        if ($post->username != $request->username) {
          $check = User::where('username', $request->username)
            ->first();

          if ($check == null) {
            $post->username = $request->username;
          } else {
            return response()->json(['status' => false, 'pesan' => 'Username ' . $request->username . ' telah tersedia. Silahkan gunakan username lainnya.']);
          }
        }

        $post->name = $request->name;
        $post->email = $request->post('email');
        $post->phone = $request->post('phone');
        $post->roles = $request->post('roles');
        $post->status = $request->post('status');

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data pengguna berhasil disimpan!"
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
    $user = User::find($id);
    if ($user->u_avatar) {
      Storage::delete($user->u_avatar);
    }
    $hapus = User::destroy($user->id);

    //jika data berhasil dihapus, akan kembali ke halaman utama
    if ($hapus) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  //reset password
  public function ResetPass($id)
  {
    $set = User::find($id);
    $set->password = Hash::make('diawansmarthome');
    $set->save();
    return response()->json(true);
  }

  //ganti status
  public function ChangeStatus($id, $val)
  {
    $set = User::find($id);
    if ($val == "1") {
      $set->status = "0";
    } else {
      $set->status = "1";
    }
    $set->save();
    return response()->json(true);
  }

  //load datatable
  public function json()
  {
    $datas = User::leftJoin('ms_employee', 'id_employee', '=', 'employee_user')->select(['id', 'email_employee as email', 'name as nama', 'username', 'position_employee', 'users.status as status', 'users.roles'])->get();

    return Datatables::of($datas)
      ->addColumn('action', function ($data) {
        //get module akses
        $id_module = get_module_id('user');

        //detail
        $btn_detail = '';
        if (isAccess('detail', $id_module, auth()->user()->roles)) {
          $btn_detail = '<a class="dropdown-item" href="' . route('user.show', $data->id) . '">Detail</a>';
        }

        //edit
        $btn_edit = '';
        if (isAccess('update', $id_module, auth()->user()->roles)) {
          $btn_edit = '<button type="button" onclick="location.href=' . "'" . route('user.edit', $data->id) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
        }

        //delete
        $btn_hapus = '';
        if (isAccess('delete', $id_module, auth()->user()->roles)) {
          $btn_hapus = '<a class="dropdown-item btn-hapus" href="#hapus" data-id="' . $data->id . '" data-nama="' . $data->nama . '">Hapus</a>';
        }

        //reset passwrod
        $btn_reset = '';
        if (isAccess('reset', $id_module, auth()->user()->roles)) {
          $btn_reset = '<a class="dropdown-item btn-reset" href="#reset" data-id="' . $data->id . '" data-nama="' . $data->nama . '">Reset Password</a>';
        }

        return '
                <div class="btn-group">
                    ' . $btn_edit . '
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        ' . $btn_detail . $btn_hapus . $btn_reset . '
                    </div>
                </div>
              ';
      })
      ->addColumn('set_posisi', function ($data) {
        $set_posisi = Positions::find($data->position_employee);
        return $set_posisi->name_position;
      })
      ->addColumn('set_status', function ($data) {
        if ($data->status == "1") {
          $btn = "success";
          $status = "Aktif";
        } else {
          $btn = "warning";
          $status = "Tidak Aktif";
        }
        $set_status = '<button type="button" class="btn btn-sm btn-' . $btn . ' btn-status" data-val="' . $data->status . '" data-id="' . $data->id . '" data-nama="' . $data->nama . '">' . $status . '</button>';
        return $set_status;
        // return reference('status',$data->status);
      })
      ->addColumn('set_role', function ($data) {
        return $data->privileges->name_usergroup ?? "";
      })
      ->rawColumns(['action', 'set_posisi', 'set_status', 'set_role'])
      ->addIndexColumn() //increment
      ->make(true);
  }

  //load pdf
  public function LoadPdf()
  {
    $data = User::all();
    $pdf = PDF::loadView('user::pdf', ['get_data' => $data]);
    // return $pdf->download('testing');//to dwonload
    return $pdf->stream();
  }

  //load excel
  public function LoadExcel()
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Nama');
    $sheet->setCellValue('B1', 'Username');
    $sheet->setCellValue('C1', 'Email');
    $sheet->setCellValue('D1', 'Hak Akses');
    $sheet->setCellValue('E1', 'Status');

    $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('center');

    $data = User::orderBy('name')->get();
    $no = 1;
    foreach ($data as $get_item) {
      $no++;
      $sheet->setCellValue('A' . $no, $get_item->name);
      $sheet->setCellValue('B' . $no, $get_item->username);
      $sheet->setCellValue('C' . $no, $get_item->email);
      $sheet->setCellValue('D' . $no, $get_item->privileges->name_usergroup);
      $sheet->setCellValue('E' . $no, reference('status', $get_item->status));

      $styleArray = [
        'borders' => [
          'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
          ],
        ],
      ];

      $sheet->getStyle('A1:E' . $no)->applyFromArray($styleArray);
    }

    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);

    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan_User_' . date('Y-m-d') . '.xlsx"');
    $writer->save('php://output');
  }

  //form import
  public function FormImport()
  {
    return view('user::import');
  }

  //proses import
  public function ProsesImport(Request $request)
  {

    $file_data = $request->file('file')->getClientOriginalName();
    // get file extension
    $extension = pathinfo($file_data, PATHINFO_EXTENSION);

    if ($extension == 'csv') {
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } elseif ($extension == 'xlsx') {
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    } else {
      $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    }

    // file path
    $spreadsheet = $reader->load($request->file('file')->getPathName());
    $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // array Count
    $arrayCount = count($allDataInSheet);

    for ($i = 2; $i <= $arrayCount; $i++) {
      $user = new User;

      $nama = ucfirst(filter_var(trim($allDataInSheet[$i]['A']), FILTER_SANITIZE_STRING));
      $email = filter_var(trim($allDataInSheet[$i]['B']), FILTER_SANITIZE_STRING);
      $username = filter_var(trim($allDataInSheet[$i]['C']), FILTER_SANITIZE_STRING);

      $user->name = $nama;
      $user->email = $email;
      $user->username = $username;
      $user->password = \Hash::make('smt');
      $user->save();
    }

    return response()->json(['status' => true]);
  }

  public function getUsersBySelect2(Request $request)
  {
    $search = $request->search;

    if ($search == '') {
      $data = User::orderby('name', 'asc')
        ->select('id', 'name', 'email')
        ->limit(10)
        ->get();
    } else {
      $data = User::orderby('name', 'asc')
        ->select('id', 'name', 'email')
        ->where('name', 'like', '%' . $search . '%')
        ->orwhere('username', 'like', '%' . $search . '%')
        ->orwhere('email', 'like', '%' . $search . '%')
        ->limit(10)
        ->get();
    }

    $response = array();
    foreach ($data as $item) {
      $response[] = array(
        "id" => $item->id,
        "text" => $item->name
      );
    }

    return response()->json($response);
  }
}