<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table = "tb_article";
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $primaryKey = 'id_article';

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Article\Database\factories\ArticleFactory::new();
    }
}