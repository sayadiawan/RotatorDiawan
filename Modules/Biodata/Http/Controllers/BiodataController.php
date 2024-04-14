<?php

namespace Modules\Biodata\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Biodata\Entities\Biodata;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Employee\Entities\Employee;
use Intervention\Image\Facades\Image;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $get_data = Biodata::find($auth->id);
        return view('biodata::index', compact('get_data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('biodata::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('biodata::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('biodata::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|unique:ms_employee,email_employee',
            'avatar' => 'nullable|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5000'
        ],[
            'name.required' => 'Nama Tidak Boleh Kosong',
            'username.required' => 'Username Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'eamil.unique' => 'Email Sudah Digunakan',
            'avatar.mimes' => 'Foto Tidak Sesuai Format',
            'avatar.max' => 'Foto Maximal 5MB'
        ]);
        if ($validated->fails()) {
            return response()->json(['status' => false, 'pesan' => $validated->errors()]);
        } else {
            $new_user = Biodata::find($id);
            //save tabel user
            $new_user->name = $request->post('name');
            $new_user->username = $request->post('username');
            $new_user->save();

            //save tabel employee
            $new_employee = Employee::find($new_user->employee_user);
            $new_employee->email_employee = $request->post('email');
            if ($request->file('avatar')) {
                $foto = $request->file('avatar');
                $foto_name = $foto->getClientOriginalName();
                $foto_path = $request->file('avatar')->move(public_path('images/user'), $foto_name);
                $new_employee->avatar = $foto_name;

                //thubmail
                $image = Image::make(public_path('/images/user/').$foto_name)->resize(100,100)->save(public_path('/images/user_thub/') . $foto_name);
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
        //
    }

    //reset password
    public function ResetPassword(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        if ($validated->fails()) {
            return response()->json(['status' => false, 'pesan' => $validated->errors()]);
        } else {
            $user = Biodata::find($id);
            $user->password = Hash::make($request->post('password'));
            $user->save();

            return response()->json(['status' => true]);
        }
    }
}