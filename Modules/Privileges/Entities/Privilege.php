<?php

namespace Modules\Privileges\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Privilege extends Model
{
  use HasFactory;
  use SoftDeletes;
  use Uuids;

  protected $table = "ms_usergroup";
  protected $dates = ['deleted_at'];
  public $incrementing = false;
  protected $primaryKey = 'id_usergroup';
  protected $fillable = [];
}