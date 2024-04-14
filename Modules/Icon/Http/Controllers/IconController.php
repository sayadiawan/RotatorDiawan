<?php

namespace Modules\Icon\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Icon\Entities\Icon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class IconController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index(Request $request)
  {
    $get_module = get_module_id('icon');

    $query = Icon::latest();
    $result = $query->filter(request(['search']))->paginate(10)->withQueryString();

    return view('icon::index', compact('get_module', 'result'));
  }

  public function rules($request)
  {
    /* $rule = [
      'file_icons' => 'max:2048|mimes:png,jpeg,gif|required|dimensions:width=512,height=512',
    ]; */

    $rule = [
      'file_icons' => 'max:2048|mimes:png,jpeg,gif|required',
    ];

    $pesan = [
      'file_icons.required' => '',
      'file_icons.max' => 'File icon tidak boleh lebih dari 2Mb!',
      'file_icons.mimes' => 'File format icon hanya .png, .jpeg, atau .gif!',
    ];

    return Validator::make($request, $rule, $pesan);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    return view('icon::create');
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
        $post = new Icon();

        if ($request->hasFile('file_icons')) {
          $post->file_icons = $request->file('file_icons')->store('icon_device', 'public');
          $post->originalfilename_icons = $request->file('file_icons')->getClientOriginalName();
          $post->originalmimetype_icons = $request->file('file_icons')->getClientOriginalExtension();
          $post->mimetype_icons = $request->file('file_icons')->getMimeType();
        } else {
          unset($post->file_icons);
          unset($post->originalfilename_icons);
          unset($post->mimetype_icons);
        }

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data icon berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data icon tidak berhasil disimpan!"
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
    return view('icon::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    $item = Icon::findOrFail($id);
    return view('icon::edit', compact('item'));
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
        $post = Icon::find($id);

        if ($request->hasFile('file_icons')) {
          if (Storage::disk('public')->exists($post->file_icons)) {
            // Storage::delete($post->file_icons);

            Storage::disk('public')->delete($post->file_icons);
          }

          $post->file_icons = $request->file('file_icons')->store('icon_device', 'public');
          $post->originalfilename_icons = $request->file('file_icons')->getClientOriginalName();
          $post->originalmimetype_icons = $request->file('file_icons')->getClientOriginalExtension();
          $post->mimetype_icons = $request->file('file_icons')->getMimeType();
        }

        $simpan = $post->save();

        DB::commit();

        if ($simpan == true) {
          return response()->json([
            'status' => true,
            'pesan' => "Data icon berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'pesan' => "Data icon tidak berhasil disimpan!"
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
    $query = Icon::where('id_icons', $id);

    $item = $query->first();

    if (Storage::disk('public')->exists($item->file_icons)) {
      Storage::disk('public')->delete($item->file_icons);
    }

    $hapus = $query->delete();

    if ($hapus == true) {
      return response()->json(['status' => true, 'pesan' => "Data icon berhasil dihapus!"], 200);
    } else {
      return response()->json(['status' => false, 'pesan' => "Data icon tidak berhasil dihapus!"], 400);
    }
  }
}