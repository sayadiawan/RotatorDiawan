<?php

namespace Modules\Biodata\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Customers\Entities\Customer;
use Modules\User\Entities\User;
use Validator;

class ApiBiodataController extends Controller
{
    public function test()
    {
        // Get some user from somewhere
        // $user = Customer::first();
        // $new = new User;
        // $new->name = "Superadmin";
        // $new->username = "super-admin";
        // $new->password = \Hash::make('admin');
        // $simpan = $new->save();
        // dd($simpan);

        // Get the token
        $token = auth('api')->user();
        dd($token);
        // $res = array(
        //     'data' => $token->id_customer
        // );
        // return response()->json($res,200);

        // $id = $token->id_customer;
    }
    
    //RULES
    public function rules($request)
    {
        $rule = [
            'name_customer' => 'required',
            'phone_customer' => 'required',
            // 'area_customer' => 'required',
            'email' => 'required|email',
            'address_customer' => 'required',
            'images_customer' => 'nullable|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
        ];
        $pesan = [
            'name_customer.required' => 'Nama Tidak Boleh Kosong',
            'phone_customer.required' => 'Nomor Telepon / Headphone Tidak Boleh Kosong',
            // 'area_customer.required' => 'Area Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email' => 'Email Tidak Sesuai format',
            'address_customer.required' => 'Alamat Tidak Boleh Kosong',
            'images_customer.mimes' => 'Format Tidak Sesuai'
        ];

        return Validator::make($request,$rule,$pesan);
    }

    //API Biodata
    public function GetData()
    {
        $set = auth('api')->user();
        $data = Customer::find($set->id_customer);
        $ar = array(
            'id_customer' => $data->id_customer,
            'name_customer'=> $data->name_customer,
            'phone_csutomer' => $data->phone_customer,
            'email' => $data->email,
            'username' => $data->username,
            'remember_token' => $data->remember_token,
            'email_token' => $data->email_token,
            'idarea_customer' => $data->area_customer ?? "",
            'area_customer' => $data->shipping->name_area ?? "",
            'address_customer' => $data->address_customer,
            'images_customer' => asset('storage/'.$data->images_customer) ?? "",
            'status' => $data->status
        );
        return response()->json(['result'=>$ar,'status'=>true],200);
    }
    
    //API UPDATE BIODATA
    public function UpdateData(Request $request)
    {
        $validator = $this->rules($request->all());
        $set = auth('api')->user();
        if ($validator->fails()) {
            return response()->json(['status'=>false,'result'=>$validator->errors()],400);
        }else{
            
            
            $new_data = Customer::find($set->id_customer); 
            $new_data->name_customer = $request->post('name_customer');
            $new_data->phone_customer = hp($request->post('phone_customer'));
            $new_data->email = $request->post('email');
            if($request->file('foto')){
                $foto_name = $request->file('foto')->getClientOriginalName();
                $foto_path = $request->file('foto')->storeAs('images/customer',$foto_name);
                $new_data->images_customer = $foto_path;
            }
            // $new_data->area_customer = $request->post('area_customer');
            $new_data->address_customer = $request->post('address_customer');
            $new_data->save();
            
            return response()->json(['status'=>true,'result'=>'Berhasil Menyimpan'],200);
        }   
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('biodata::index');
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
    public function update(Request $request)
    {
        $user = auth('api')->user();

        if(!\Hash::check($request->post('old_password'), $user->password)){
            // return redirect()->route('user.adm-password.edit')->with('status', 'Password Lama Salah');
            $ar = array(
                'msg' => 'Password Lama Salah',
                'status' => false
            );
            return response()->json($ar,400);
        }

        if($request->post('password')!=$request->post('password_confirmation')){
            // return redirect()->route('user.adm-password.edit')->with('status', 'Password Konfirm Salah');  
            $ar = array(
                'msg' => 'Password Konfirm Salah',
                'status' => false
            );      
            return response()->json($ar,400);
        }
        
        $new_data = Customer::find($user->id_customer); 
        $new_data->password = \Hash::make($request->get('password'));
        $simpan = $new_data->save();
        
        if ($simpan) {
            $ar = array(
                'msg' => 'Password Berhasil',
                'status' => true
            );      
            return response()->json($ar,200);
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
}