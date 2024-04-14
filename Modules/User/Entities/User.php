<?php

namespace Modules\User\Entities;

use Modules\User\Entities\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Employee\Entities\Employee;
use Modules\Privileges\Entities\Privilege;

class User extends Model
{
  use HasFactory;
  use SoftDeletes;
  use Uuids;

  protected $fillable = [];
  protected $table = "users";
  protected $dates = ['deleted_at'];
  public $incrementing = false;
  protected $primaryKey = 'id';

  /**
   * Get the user associated with the User
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function employee(): HasOne
  {
    return $this->hasOne(Employee::class, 'id_employee', 'employee_user');
  }

  /**
   * Get the privileges associated with the User
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function privileges(): HasOne
  {
    return $this->hasOne(Privilege::class, 'id_usergroup', 'roles');
  }
}