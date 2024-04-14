<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Customers\Entities\Customer;
use Validator;


class RegisterCustomerController extends Controller
{
   
    //rules
    public function rules($request)
    {
        $rule = [
            'name_customer' => 'required',
            'phone_customer' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
        $pesan = [
            'name_customer.required' => 'Nama Tidak Boleh Kosong',
            'phone_customer.required' => 'Nomor Telepon / Headphone Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email' => 'Email Tidak Sesuai format',
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.confirmed' => 'Password Tidak Sesuai Dengan Password Konfirmasi',
            'password_confirmation.required' => 'Password Konfirmasi Tidak Boleh Kosong'
        ];

        return Validator::make($request,$rule,$pesan);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->rules($request->all());
        if ($validator->fails()) {
            return response()->json(['status'=>false,'result'=>$validator->errors()],400);
        }else{
            
            $new_data = new Customer; 
            $new_data->name_customer = $request->post('name_customer');
            $new_data->phone_customer = hp($request->post('phone_customer'));
            $new_data->email = $request->post('email');
            $new_data->password = \Hash::make($request->post('password'));
            $new_data->status = "1";
            $new_data->save();
            
            return response()->json(['status'=>true,'result'=>'Berhasil Mendaftar'],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}