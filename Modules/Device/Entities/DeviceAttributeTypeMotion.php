<?php

namespace Modules\Device\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Device\Entities\Device;

class DeviceAttributeTypeMotion extends Model
{
  use Uuid;
  use HasFactory;
  use SoftDeletes;
  protected $fillable = [];

  protected $dates = ['deleted_at'];
  protected $table = "tb_device_attribute_type_motion";
  protected $primaryKey = 'id_device_attribute_type_motion';

  /**
   * Get the position associated with the Employee
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function deviceattributetype()
  {
    return $this->hasOne(DeviceAttributeType::class, 'device_attribute_type_id', 'id_device_attribute_type');
  }
}