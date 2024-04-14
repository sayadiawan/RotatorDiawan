<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\PositionFactory::new();
    }
}
