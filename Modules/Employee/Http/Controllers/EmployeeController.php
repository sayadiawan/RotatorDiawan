<?php

namespace Modules\Employee\Http\Controllers;

use Validator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Employee\Entities\Employee;
use PDF;
use DataTables;
use Intervention\Image\Facades\Image;
use Modules\Position\Entities\Positions;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function rules($request)
    {
        $rule = [
            'name_employee' => 'required',
            'phone_employee' => 'required',
            'email_employee' => 'email|unique:ms_employee,email_employee',
            'address_employee' => 'required',
            'position_employee' => 'required',
            'status' => 'required',
            'avatar' => 'nullable|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
            'noktp_employee' => 'required|max:16'
        ];
        $pesan = [
            'name_employee.required' => 'Nama Wajib di isi',
            'phone_employee.required' => 'Nomor Telepon Wajib di isi',
            'address_employee.required' => 'Alamat Wajib di isi',
            'status.required' => 'Status Wajib di isi',
            'position_employee.required' => 'Posisi Wajib di isi',
            'email_employee.unique' => 'Email Sudah digunakan',
            'email_employee.email' => 'Email Format Tidak Sesuai',
            'avatar.mimes' => 'Foto tidak sesuai format',
            'noktp_employee.required' => 'Nomor KTP Wajib di isi',
            'noktp_employee.max' => 'Digit KTP Tidak Sesuai',

        ];

        return Validator::make($request, $rule, $pesan);
    }

    public function index()
    {
        $get_module = get_module_id('employee');
        return view('employee::index', compact('get_module'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data_jabatan = Positions::orderBy('name_position')->get();
        return view('employee::create', compact('data_jabatan'));
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


            $new_employee = new Employee;
            $new_employee->name_employee = $request->post('name_employee');
            $new_employee->phone_employee = $request->post('phone_employee');
            $new_employee->email_employee = $request->post('email_employee');
            $new_employee->position_employee = $request->post('position_employee');
            $new_employee->status = $request->post('status');
            $new_employee->address_employee = $request->post('address_employee');
            $new_employee->noktp_employee = $request->post('noktp_employee');
            if ($request->file('avatar')) {
                $foto = $request->file('avatar');
                $foto_name = $request->file('avatar')->getClientOriginalName();
                $foto_path =  $request->file('avatar')->storeAs('images/user', $foto_name);
                $new_employee->avatar = $foto_name;

                //thubmail
                Image::make($foto)->fit(300)->save('storage/images/user_thub/' . $foto_name);
            }

            $new_employee->save();

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
        $data = Employee::find($id);
        return view('employee::show', ['get_data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = Employee::find($id);
        $data_jabatan = Positions::orderBy('name_position')->get();
        return view('employee::edit', ['get_data' => $data, 'data_jabatan' => $data_jabatan]);
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


            $new_employee = Employee::find($id);
            $new_employee->name_employee = $request->post('name_employee');
            $new_employee->phone_employee = $request->post('phone_employee');
            $new_employee->email_employee = $request->post('email_employee');
            $new_employee->position_employee = $request->post('position_employee');
            $new_employee->status = $request->post('status');
            $new_employee->address_employee = $request->post('address_employee');
            $new_employee->noktp_employee = $request->post('noktp_employee');
            if ($request->file('avatar')) {
                $foto = $request->file('avatar');
                $foto_name = $request->file('avatar')->getClientOriginalName();
                $foto_path =  $request->file('avatar')->storeAs('images/user', $foto_name);
                $new_employee->avatar = $foto_name;

                //thubmail
                Image::make($foto)->fit(300)->save('storage/images/user_thub/' . $foto_name);
            }

            $new_employee->save();

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
        $set = Employee::find($id);
        $set->deleted_at = date('Y-m-d H:i:s');
        $set->save();
        return response()->json(true);
    }

    //load datatable
    public function json()
    {
        $datas = Employee::select(['id_employee', 'name_employee', 'phone_employee', 'position_employee', 'status']);
        
        return Datatables::of($datas)
            ->addColumn('action', function ($data) {

                //get module akses
                $id_module = get_module_id('employee');

                //detail
                $btn_detail = '';
                if (isAccess('detail', $id_module, auth()->user()->roles)) {
                    $btn_detail = '<a class="dropdown-item" href="' . route('employee.show', $data->id_employee) . '">Detail</a>';
                }

                //edit
                $btn_edit = '';
                if (isAccess('update', $id_module, auth()->user()->roles)) {
                    $btn_edit = ' <button type="button" onclick="location.href=' . "'" . route('employee.edit', $data->id_employee) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
                }

                //delete
                $btn_hapus = '';
                if (isAccess('delete', $id_module, auth()->user()->roles)) {
                    $btn_hapus = '<a class="dropdown-item btn-hapus" href="#hapus" data-id="' . $data->id_employee . '" data-nama="' . $data->name . '">Hapus</a>';
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
            ->addColumn('set_posisi', function ($data) {
                return $data->position->name_position;
            })
            ->addColumn('set_status', function ($data) {
                $set_status = reference('status', $data->status);
                return $set_status ?? "";
            })
            ->addIndexColumn() //increment
            ->make(true);
    }

    // public function LoadPdf($status = null, $id = null)
    // {
    //     if ($status == "personal") {
    //         $data = Employee::find($id);
    //         $set_status = "1"; //perpegawai
    //     } else {
    //         $data = Employee::all();
    //         $set_status = "0"; //semua pegawai
    //     }
    //     $pdf = PDF::loadView('employee::pdf', ['get_data' => $data, 'status' => $set_status]);
    //     return $pdf->stream();
    // }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nama Pegawai');
        $sheet->setCellValue('B1', 'Nomor KTP Pegawai');
        $sheet->setCellValue('C1', 'Nomor Telepon');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Alamat');
        $sheet->setCellValue('F1', 'Jabatan');
        $sheet->setCellValue('G1', 'Status');

        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');

        $data = Employee::orderBy('name_employee')->get();
        $no = 1;
        foreach ($data as $get_item) {
            $no++;
            $sheet->setCellValue('A' . $no, $get_item->name_employee);
            $sheet->setCellValue('B' . $no, $get_item->noktp_employee);
            $sheet->setCellValue('C' . $no, $get_item->phone_employee);
            $sheet->setCellValue('D' . $no, $get_item->email_employee);
            $sheet->setCellValue('E' . $no, $get_item->address_employee);
            $sheet->setCellValue('F' . $no, $get_item->position->name_position);
            $sheet->setCellValue('G' . $no,  reference('status', $get_item->status));

            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ],
            ];

            $sheet->getStyle('A1:G' . $no)->applyFromArray($styleArray);
        }

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_Pegawai_' . date('Y-m-d') . '.xlsx"');
        $writer->save('php://output');
    }

    public function json_data($id = NULL)
    {
        if ($id == NULL) {
            $produk = new Employee;
            $data = $produk;
            if (request()->has('position')) {
                $data = $produk->where('position_employee', request()->position)->get(['*', 'name_employee as text', 'id_employee as id']);
            }
            return response()->json($data);
        } else {
            $produk = Employee::find($id);
            $typecategory = $produk->category->typecategory;
            $produk->shopper = $typecategory;
            return response()->json($produk);
        }
    }
}