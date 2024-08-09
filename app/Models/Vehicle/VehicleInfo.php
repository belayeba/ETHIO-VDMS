<?php

namespace App\Models\Vehicle;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VehicleInfo extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'detail_id',
        'detail',
        'register_by',
        'date',
        'vehicle_id',
        'mileage',
        'driver_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->detail_id)) {
                $model->detail_id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'register_by', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'driver_id');
    }
}
