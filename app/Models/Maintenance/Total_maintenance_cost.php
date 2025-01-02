<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Total_maintenance_cost extends Model
{
    protected $table = 'total_maintenance_costs';
    protected $primaryKey = 'total_maintenance_cost_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
  
    protected static function boot()
           {
    parent::boot();
    static::creating(function ($model) {
        if (empty($model->{$model->getKeyName()})) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        }
    });
}
protected $fillable = [
    'total_maintenance_cost_id',
    'maintained_vehicle_id',
    'sparepart_cost',
    'machine_cost',
    'labor_cost',
    'total_cost',
    'created_at'
];
      public function maintained_vehicle(): BelongsTo {
       return $this->belongsTo( Maintained_vehicle::class);
     }
}
