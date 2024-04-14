<?php

namespace Modules\Device\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Device\Entities\Device;
use Modules\Device\Entities\DeviceAttribute;
use Illuminate\Database\Eloquent\Relations\HasOne;



class DeviceCommand extends Model
{
  use Uuid;
  use HasFactory;
  use SoftDeletes;
  protected $fillable = [];

  protected $dates = ['deleted_at'];
  protected $table = "tb_devices_command";
  protected $primaryKey = 'id_devices_command';

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
  public function device()
  {
    return $this->belongsTo(Device::class, 'device_id', 'id_devices')->withDefault();
  }

  public function deviceatribute()
  {
    return $this->belongsTo(DeviceAttribute::class, 'device_atribute_id', 'id_device_atribute')->withDefault();
  }
}