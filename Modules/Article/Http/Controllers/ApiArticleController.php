<?php

namespace Modules\Article\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Article\Entities\Article;
use Modules\Customers\Entities\Customer;
use Modules\User\Entities\User;
use Validator;

class ApiArticleController extends Controller
{
    public function GetData()
    {
        $data = Article::where('publish','1')->orderBy('date_article')->get();
        if ($data) {
            $ar = array();
            foreach ($data as $item) {
                $ar[] = array(
                    'id_article'        => $item->id_article,
                    'thumbnail_article' => $item->thumbnail_article,
                    'title_article'     => $item->title_article,
                    'content_article'   => $item->content_article,
                    'thumbnail_article' => $item->thumbnail_article,
                    'date_article'      => $item->date_article,
                    'publish'           => $item->publish,
                    'created_at'        => $item->created_at,
                    'updated_at'        => $item->updated_at,
                    'deleted_at'        => $item->deleted_at,
                );
            }
            return response()->json(['result'=>$ar,'status'=>true],200);
        }else{
            return response()->json(['result'=>'Data Kosong','status'=>false],400);
        }
    }
}