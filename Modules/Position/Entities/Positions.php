<?php

namespace Modules\Position\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Positions extends Model
{
    use HasFactory;
    use Uuids;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = "ms_position";
    protected $primaryKey = 'id_position';
    public $incrementing = false;
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Position\Database\factories\PositionsFactory::new();
    }
}