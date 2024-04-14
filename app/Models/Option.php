<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class Option extends Model
{
    use Uuid;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [];
    
    protected $dates = ['deleted_at'];
    protected $table = "ms_option";
    protected $primaryKey = 'id_option';
}
