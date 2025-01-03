<?php

namespace App\Models\Maintenance;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Maintenance_record extends Model
{
    protected $table = 'maintenance_records';
    protected $primaryKey = 'maintenance_record_id';
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
        'maintenance_record_id',
        'maintenance_start_date',
    'maintained_vehicle_id',
        'maintenance_end_date',
        'completed_task',
        'time_elapsed',
        'maintained_by',
        'created_at'
    ];
    public function maintained_vehicle(): BelongsTo {
        return $this->belongsTo( Maintained_vehicle::class);
    }
    public function user(): BelongsTo {
        return $this->belongsTo( User::class, 'id','maintained_by' );
    }

}