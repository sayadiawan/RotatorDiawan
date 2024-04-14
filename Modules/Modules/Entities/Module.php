<?php

namespace Modules\Modules\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Modules\Entities\Roles;

class Module extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;

    protected $table = "ms_module";
    protected $dates = ['deleted_at'];
    public $incrementing = false;
    protected $primaryKey = 'id_module';
    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Modules\Database\factories\ModuleFactory::new();
    }

    /**
     * Get the user associated with the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function module(): HasOne
    {
        return $this->hasOne(Module::class, 'id_module', 'upid_module');
    }

    /**
     * Get all of the comments for the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class, 'upid_module', 'id_module');
    }

    /**
     * Get the user associated with the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(Roles::class, 'module_gmd', 'id_module');
    }
}
