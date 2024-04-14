<?php

namespace Modules\Import\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Modules\User\Entities\User;
use Modules\Employee\Entities\Employee;
use Modules\Position\Entities\Positions;
use Modules\Privileges\Entities\Privilege;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('import::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('import::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
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
        $p = 1;
        for ($i = 2; $i <= $arrayCount; $i++) {
            if ($request->post('set_jenis') == "1") {
                if (empty($allDataInSheet[$i]['B'])) {
                    continue;
                }

                $cek_user = User::where('username', $allDataInSheet[$i]['D'])->first();
                if (!empty($cek_user)) {
                    $user = User::find($cek_user->id);
                } else {
                    $user = new User;
                }
                //pegawai
                $get_employee = Employee::where('name_employee', $allDataInSheet[$i]['B'])->first();
                $user->employee_user = $get_employee->id_employee;
                $user->name = $get_employee->name_employee;
                //roles
                $get_role = Privilege::where('name_usergroup', $allDataInSheet[$i]['C'])->first();
                $user->roles = $get_role->id_usergroup;

                $user->username = $allDataInSheet[$i]['D'];
                $user->password = \Hash::make('smt');
                if (strtolower($allDataInSheet[$i]['E']) == "aktif") {
                    $user->status = "1";
                } else {
                    $user->status = "0";
                }

                $user->save();
            } elseif ($request->post('set_jenis') == "2") {
                if (empty($allDataInSheet[$i]['B'])) {
                    continue;
                }

                $cek_employee = Employee::where('name_employee', $allDataInSheet[$i]['B'])->first();
                if (!empty($cek_employee)) {
                    $employee = Employee::find($cek_employee->id_employee);
                } else {
                    $employee = new Employee;
                }
                $employee->name_employee = $allDataInSheet[$i]['B'];
                $employee->noktp_employee = $allDataInSheet[$i]['C'];
                $employee->phone_employee = $allDataInSheet[$i]['D'];
                $employee->email_employee = $allDataInSheet[$i]['E'];
                $employee->address_employee = $allDataInSheet[$i]['F'];
                //jabatan
                $jabatan = $allDataInSheet[$i]['G'];
                $get_jabatan = Positions::where('name_position', $jabatan)->first();
                $employee->position_employee = $get_jabatan['id_position'];
                if (strtolower($allDataInSheet[$i]['H']) == "aktif") {
                    $employee->status = "1";
                } else {
                    $employee->status = "0";
                }
                $employee->save();
            }
        }
        return response()->json(['status' => true]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('import::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('import::edit');
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
        //
    }

    //function template
    public function Template($type)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ],
            ],
        ];

        if ($type == "user") {
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Nama Pegawai');
            //hak akses
            $set_akses = Privilege::all();
            $akses = '';
            foreach ($set_akses as $item) {
                $akses .= $item->name_usergroup . ' , ';
            }
            $sheet->setCellValue('C1', 'Hak Akses (' . $akses . ')');
            $sheet->setCellValue('D1', 'Username');
            $sheet->setCellValue('E1', 'Status (Aktif , Tidak Aktif)');

            $sheet->getStyle('A1:E3')->applyFromArray($styleArray);
        }
        if ($type == "employee") {
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Nama Pegawai');
            $sheet->setCellValue('C1', 'Nomor KTP Pegawai');
            $sheet->setCellValue('D1', 'Nomor Telepon');
            $sheet->setCellValue('E1', 'Email');
            $sheet->setCellValue('F1', 'Alamat');
            //jataban
            $set_jabatan = Positions::all();
            $jabatan = '';
            foreach ($set_jabatan as $item) {
                $jabatan .= $item->name_position . ' , ';
            }
            $sheet->setCellValue('G1', 'Jabatan (' . $jabatan . ')');
            $sheet->setCellValue('H1', 'Status (Aktif , Tidak Aktif)');
            $sheet->getStyle('A1:H3')->applyFromArray($styleArray);
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Template-Import-' . $type . '.xlsx"');
        $writer->save('php://output');
    }
}