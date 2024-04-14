<?php

namespace Modules\Device\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Device\Entities\Device;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DeviceAttribute extends Model
{
  use Uuid;
  use HasFactory;
  use SoftDeletes;

  protected $table = "tb_device_atribute";
  protected $dates = ['deleted_at'];
  public $incrementing = false;
  protected $primaryKey = 'id_device_atribute';
  protected $fillable = ['type', 'name_device_atribute', 'code'];

  /**
   * Get the attendance associated with the Employee
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */

  /**
   * Get the position associated with the Employee
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
}