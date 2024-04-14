<?php

namespace Modules\Option\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Option\Entities\Options;
use Validator;

class OptionController extends Controller
{
    //rules
    public function rules($request)
    {
        $rule = [
            'name_company' => 'required',
            'description' => 'required',
            'logo' => 'nullable|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
            'favicon' => 'nullable|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
        ];
        $pesan = [
            'name_company.required' => 'Nama Website Wajib di isi',
            'description.required' => 'Deskripsi Website Wajib di isi',
            'address_employee.required' => 'Alamat Wajib di isi',
            'logo.mimes' => 'Gambar tidak sesuai format',
            'favicon.mimes' => 'Gambar tidak sesuai format',
        ];

        return Validator::make($request, $rule, $pesan);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $get_data = Options::first();
        $get_module = get_module_id('option');
        return view('option::index', compact('get_data', 'get_module'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('option::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $set_data = Options::first();
        if (!empty($set_data->id_option)) {
            $data = Options::find($set_data->id_option);

            $validator = $this->rules($request->all());
            if ($validator->fails()) {
                return response()->json(['status' => false, 'pesan' => $validator->errors()]);
            } else {
                $data->name_company = $request->name_company;
                $data->description = $request->description;
                //logo
                if ($request->file('logo')) {
                    $request->file('logo')->move('static', $request->file('logo')->getClientOriginalName());
                    $data->logo = $request->file('logo')->getClientOriginalName();
                }
                //favicon
                if ($request->file('favicon')) {
                    $request->file('favicon')->move('static', $request->file('favicon')->getClientOriginalName());
                    $data->favicon = $request->file('favicon')->getClientOriginalName();
                }
                $data->save();
            }
        } else {
            $data = new Options();

            $validator = $this->rules($request->all());
            if ($validator->fails()) {
                return response()->json(['status' => false, 'pesan' => $validator->errors()]);
            } else {
                $data->name_company = $request->name_company;
                $data->description = $request->description;
                //logo
                if ($request->file('logo')) {
                    $request->file('logo')->move('static', $request->file('logo')->getClientOriginalName());
                    $data->logo = $request->file('logo')->getClientOriginalName();
                }
                //favicon
                if ($request->file('favicon')) {
                    $request->file('favicon')->move('static', $request->file('favicon')->getClientOriginalName());
                    $data->favicon = $request->file('favicon')->getClientOriginalName();
                }
                $data->save();
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
        return view('option::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('option::edit');
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
}