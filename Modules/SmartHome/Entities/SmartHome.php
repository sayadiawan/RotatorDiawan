<?php

namespace Modules\SmartHome\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Modules\Room\Entities\Room;
use Modules\SmartHomeDevice\Entities\SmartHomeDevice;
use Modules\User\Entities\User as EntitiesUser;

class SmartHome extends Model
{
  use HasFactory;
  use SoftDeletes;
  use Uuids;

  protected $table = "tb_smarthomes";
  protected $dates = ['deleted_at'];
  public $incrementing = false;
  protected $primaryKey = 'id_smarthomes';
  protected $fillable = [];

  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? false, function ($query, $search) {
      return $query->where(function ($query) use ($search) {
        $query->whereHas('user', function ($query) use ($search) {
          return $query->where('name', 'LIKE', '%' . $search . '%')
            ->whereNull('deleted_at');
        })->orWhereHas('room', function ($query) use ($search) {
          return $query->where('name_rooms', 'LIKE', '%' . $search . '%')
            ->whereNull('deleted_at');
        });
      });
    });
  }

  public function user()
  {
    return $this->belongsTo(EntitiesUser::class, 'users_id', 'id')->withDefault();
  }

  public function room()
  {
    return $this->belongsTo(Room::class, 'rooms_id', 'id_rooms')->withDefault();
  }

  public function smarthomedevice()
  {
    return $this->hasMany(SmartHomeDevice::class, 'smarthomes_id', 'id_smarthomes');
  }
}