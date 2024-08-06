<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DriverChangeModel extends Model
{
    use SoftDeletes;

    protected $table = 'driver_changes'; // Specify the table name
    protected $primaryKey = 'driver_change_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'driver_change_id',
        'vehicle_id',
        'old_driver_id',
        'new_driver_id',
        'change_date',
        'created_at',
        'updated_at'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function oldDriver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'old_driver_id');
    }

    public function newDriver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'new_driver_id');
    }
}
