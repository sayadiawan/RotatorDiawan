<?php

namespace Modules\Site\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Site\Entities\DeviceAttribute;
use Modules\Site\Entities\DeviceCommand;
use Modules\Site\Entities\DeviceAttributeValue;
use Modules\SmartHomeDevice\Entities\SmartHomeDevice;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Icon\Entities\Icon;



class Site extends Model
{
  use Uuid;
  use HasFactory;
  use SoftDeletes;
  protected $fillable = [];

  protected $dates = ['deleted_at'];
  protected $table = "ms_sites";
  protected $primaryKey = 'id_sites';

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
  public function deviceattributetype()
  {
    return $this->hasOne(DeviceAttributeType::class, 'device_id', 'id_sites');
  }

   public function deviceattributevalue()
  {
    return $this->hasMany(DeviceAttributeValue::class, 'device_id', 'id_sites');
  }

  public function devicecommand()
  {
    return $this->hasMany(DeviceCommand::class, 'device_id', 'id_sites');
  }

  public function deviceAttribute()
  {
    return $this->hasMany(DeviceAttribute::class, 'type', 'type');
  }


  public function smarthomedevice()
  {
    return $this->hasMany(SmartHomeDevice::class, 'devices_id', 'id_sites');
  }

  public function icon()
  {
    return $this->belongsTo(Icon::class, 'icons_id', 'id_icons')->withDefault();
  }


 
}