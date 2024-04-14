<?php

namespace Modules\Article\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Article\Entities\Article;
use Validator;
use DataTables;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //rules
    public function rules($request)
    {
        $rule = [
            'title_article' => 'required',
            'content_article' => 'required',
            'date_article' => 'required',
            'publish' => 'required',
            'thumbnail_article' => 'nullable|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
        ];
        $pesan = [
            'title_article.required' => 'Judul Wajib di isi',
            'content_article.required' => 'Isi Wajib di isi',
            'date_article.required' => 'Tanggal Wajib di isi',
            'publish.required' => 'Status Wajib di isi',
            'thumbnail_article.mimes' => 'Gambar tidak sesuai format',
        ];
        return Validator::make($request, $rule, $pesan);
    }
    //datatable
    public function json()
    {
        $datas = Article::select(['id_article', 'title_article', 'content_article', 'date_article', 'publish', 'thumbnail_article', 'updated_at']);

        return Datatables::of($datas)
            ->addColumn('action', function ($data) {

                //get module akses
                $id_module = get_module_id('article');

                //detail
                $btn_detail = '';
                if (isAccess('detail', $id_module, auth()->user()->roles)) {
                    $btn_detail = '<a class="dropdown-item" href="' . route('article.show', $data->id_article) . '">Detail</a>';
                }

                //edit
                $btn_edit = '';
                if (isAccess('update', $id_module, auth()->user()->roles)) {
                    $btn_edit = ' <button type="button" onclick="location.href=' . "'" . route('article.edit', $data->id_article) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
                }

                //delete
                $btn_hapus = '';
                if (isAccess('delete', $id_module, auth()->user()->roles)) {
                    $btn_hapus = '<a class="dropdown-item btn-hapus" href="#hapus" data-id="' . $data->id_article . '" data-nama="' . $data->title_article . '">Hapus</a>';
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
            ->addColumn('set_tgl', function ($data) {
                return fdate($data->updated_at, 'HHDDMMYYYY');
            })
            ->addColumn('set_status', function ($data) {
                $set_status = reference('status', $data->publish);
                return $set_status ?? "";
            })
            ->addIndexColumn() //increment
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $get_module = get_module_id('article');
        return view('article::index', compact('get_module'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('article::create');
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
            $data = new Article();
            $data->title_article = $request->title_article;
            $data->content_article = $request->content_article;
            $data->date_article = $request->date_article;
            $data->publish = $request->publish;
            if ($request->file('thumbnail_article')) {
                $foto = $request->file('thumbnail_article');
                $foto_name = $request->file('thumbnail_article')->getClientOriginalName();
                $foto_path =  $request->file('thumbnail_article')->storeAs('images/artikel', $foto_name);
                $data->thumbnail_article = $foto_name;

                //thubmail
                Image::make($foto)->fit(300)->save('storage/images/artikel_thub/' . $foto_name);
            }
            $simpan = $data->save();
            if ($simpan) {
                return response()->json(['status' => true]);
            } else {
                return response()->json(['status' => false]);
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
        $get_data = Article::find($id);
        return view('article::show', compact('get_data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $get_data = Article::find($id);
        return view('article::edit', compact('get_data'));
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
            $data = Article::find($id);
            $data->title_article = $request->title_article;
            $data->content_article = $request->content_article;
            $data->date_article = $request->date_article;
            $data->publish = $request->publish;
            if ($request->file('thumbnail_article')) {
                $foto = $request->file('thumbnail_article');
                $foto_name = $request->file('thumbnail_article')->getClientOriginalName();
                $foto_path =  $request->file('thumbnail_article')->storeAs('images/artikel', $foto_name);
                $data->thumbnail_article = $foto_name;

                //thubmail
                Image::make($foto)->fit(300)->save('storage/images/artikel_thub/' . $foto_name);
            }
            $simpan = $data->save();
            if ($simpan) {
                return response()->json(['status' => true]);
            } else {
                return response()->json(['status' => false]);
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
        $set = Article::find($id);
        if ($set->thumbnail_article) {
            \Storage::delete($set->thumbnail_article);
        }
        $set->deleted_at = date('Y-m-d H:i:s');
        $set->save();
        return response()->json(true);
    }
}