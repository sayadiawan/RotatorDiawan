<?php

namespace Modules\Icon\Entities;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Icon extends Model
{
  use HasFactory;
  use SoftDeletes;
  use Uuids;

  protected $table = "ms_icons";
  protected $dates = ['deleted_at'];
  public $incrementing = false;
  protected $primaryKey = 'id_icons';
  protected $fillable = [];

  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? false, function ($query, $search) {
      return $query->where('originalfilename_icons', 'LIKE', '%' . $search . '%')
        ->whereNull('deleted_at');
    });
  }
}