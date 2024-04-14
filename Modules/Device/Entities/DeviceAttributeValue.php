<?php

namespace Modules\Device\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Device\Entities\Device;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Modules\Device\Entities\DeviceAttributeType;

class DeviceAttributeValue extends Model
{
    use Uuid;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [];

    protected $dates = ['deleted_at'];
    protected $table = "tb_device_attribute_value";
    protected $primaryKey = 'id_device_attribute_value';

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
        return $this->hasOne(Device::class, 'device_id', 'id_devices');
    }

    public function deviceAttribute()
    {
        return $this->hasOne(DeviceAttributeType::class, 'device_attribute_type_id', 'id_device_attribute_type');
    }
  
}