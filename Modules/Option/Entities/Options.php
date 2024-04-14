<?php

namespace Modules\Option\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class Options extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $fillable = [];
    protected $table = "ms_option";
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $primaryKey = 'id_option';

    protected static function newFactory()
    {
        return \Modules\Option\Database\factories\OptionsFactory::new();
    }
}