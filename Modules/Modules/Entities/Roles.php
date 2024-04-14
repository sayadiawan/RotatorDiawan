<?php

namespace Modules\Modules\Entities;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Roles extends Model
{
    use HasFactory;

    use Uuids;

    protected $table = "ms_groupmodule";
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $fillable = ['usergroup_gmd'];

    
    protected static function newFactory()
    {
        return \Modules\Modules\Database\factories\RolesFactory::new();
    }

    /**
     * Get the user associated with the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function module(): HasOne
    {
        return $this->hasOne(Module::class, 'id_module', 'module_gmd');
    }
    
}
