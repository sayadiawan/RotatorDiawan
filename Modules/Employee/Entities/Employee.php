<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Position\Entities\Positions;

class Employee extends Model
{
    use Uuid;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [];

    protected $dates = ['deleted_at'];
    protected $table = "ms_employee";
    protected $primaryKey = 'id_employee';

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
    public function position(): HasOne
    {
        return $this->hasOne(Positions::class, 'id_position', 'position_employee');
    }
}