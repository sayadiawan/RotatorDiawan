<?php

namespace Modules\SmartHomeDevice\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Modules\Device\Entities\Device;
use Modules\Room\Entities\Room;
use Modules\SmartHome\Entities\SmartHome;
use Modules\User\Entities\User as EntitiesUser;

class SmartHomeDevice extends Model
{
  use HasFactory;
  use SoftDeletes;
  use Uuids;

  protected $table = "tb_smarthome_devices";
  protected $dates = ['deleted_at'];
  public $incrementing = false;
  protected $primaryKey = 'id_smarthome_devices';
  protected $fillable = [];
  protected $softDelete = true;

  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? false, function ($query, $search) {
      return $query->where(function ($query) use ($search) {
        $query->whereHas('device', function ($query) use ($search) {
          return $query->where('name_devices', 'LIKE', '%' . $search . '%')
            ->whereNull('deleted_at');
        });
      });
    });
  }

  public function smarthome()
  {
    return $this->belongsTo(SmartHome::class, 'smarthomes_id', 'id_smarthomes')->withDefault();
  }

  public function device()
  {
    return $this->belongsTo(Device::class, 'devices_id', 'id_devices')->withDefault();
  }
}