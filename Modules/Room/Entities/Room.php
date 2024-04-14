<?php

namespace Modules\Room\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Room extends Model
{
  use HasFactory;
  use SoftDeletes;
  use Uuids;

  protected $table = "ms_rooms";
  protected $dates = ['deleted_at'];
  public $incrementing = false;
  protected $primaryKey = 'id_rooms';
  protected $fillable = ['name_rooms', 'code_rooms'];
  
}