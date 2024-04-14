<?php

namespace App\Models;

use Modules\Employee\Entities\Employee;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Notifications\Notifiable;
use Modules\Privileges\Entities\Privilege;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Customer\Entities\Customer;

class User extends Authenticatable implements JWTSubject

{

  use HasFactory, Notifiable;

  use SoftDeletes;

  //JWT
  // Rest omitted for brevity

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
    return [];
  }

  /**

   * The attributes that are mass assignable.

   *

   * @var array

   */

  protected $fillable = [

    'name',

    'username',

    'avatar',

    'password',

  ];



  /**

   * The attributes that should be hidden for arrays.

   *

   * @var array

   */

  protected $hidden = [

    'password',

    'remember_token',

  ];



  /**

   * The attributes that should be cast to native types.

   *

   * @var array

   */

  protected $casts = [

    'email_verified_at' => 'datetime',

  ];

  public function employee()
  {

    return $this->belongsTo(Employee::class, 'employee_user', 'id_employee')->withDefault();
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customer_user', 'id_customer')->withDefault();
  }

  public function usergroup()
  {
    return $this->belongsTo(Privilege::class, 'roles', 'id_usergroup')->withDefault();
  }
}