<?php

namespace Modules\Biodata\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Employee\Entities\Employee;
class Biodata extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [];
    
    protected $dates = ['deleted_at'];
    protected $table = "users";

    /**
     * Get the user associated with the Biodata
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'id_employee', 'employee_user');
    }
}