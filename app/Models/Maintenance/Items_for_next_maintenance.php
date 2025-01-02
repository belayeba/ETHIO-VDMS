<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Items_for_next_maintenance extends Model
{
    protected $table = 'items_for_next_maintenances';
    protected $primaryKey = 'items_for_next_maintenance_id';
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
        'items_for_next_maintenance_id',
    'maintained_vehicle_id',
        'part_type',
        'measurment',
        'quantity',
        'part_no',
        'created_at'
    ];
 
    public function maintained_vehicle(): BelongsTo {
        return $this->belongsTo( Maintained_vehicle::class);
    }
}
