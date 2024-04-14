<?php

namespace Modules\Device\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Device\Entities\Device;
use Modules\Device\Entities\DeviceAttributeValue;



class DeviceAttributeType extends Model
{
  use Uuid;
  use HasFactory;
  use SoftDeletes;
  protected $fillable = [];

  protected $dates = ['deleted_at'];
  protected $table = "tb_device_attribute_type";
  protected $primaryKey = 'id_device_attribute_type';

  /**
   * Get the position associated with the Employee
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function device()
  {
    return $this->hasOne(Device::class, 'device_id', 'id_devices');
  }

  public function deviceAttributeValue()
  {
    return $this->hasMany(DeviceAttributeValue::class, 'device_attribute_type_id', 'id_device_attribute_type');
  }

  public function deviceattributetypeswitch()
  {
    return $this->belongsTo(DeviceAttributeTypeSwitch::class, 'id_device_attribute_type', 'device_attribute_type_id')->withDefault();
  }

  public function deviceattributetyperange()
  {
    return $this->belongsTo(DeviceAttributeTypeRange::class, 'id_device_attribute_type', 'device_attribute_type_id')->withDefault();
  }

  public function deviceattributetypemode()
  {
    return $this->hasMany(DeviceAttributeTypeMode::class, 'device_attribute_type_id', 'id_device_attribute_type')->orderBy('name_device_attribute_type_mode');
  }

  public function deviceattributetypemotion()
  {
    return $this->hasMany(DeviceAttributeTypeMotion::class, 'device_attribute_type_id', 'id_device_attribute_type');
  }

  public function deviceattributetypelock()
  {
    return $this->hasMany(DeviceAttributeTypeLock::class, 'device_attribute_type_id', 'id_device_attribute_type');
  }

  public function deviceattributetypemonitoring()
  {
    return $this->belongsTo(DeviceAttributeTypeMonitoring::class, 'device_attribute_type_id', 'id_device_attribute_type')->withDefault();
  }
}