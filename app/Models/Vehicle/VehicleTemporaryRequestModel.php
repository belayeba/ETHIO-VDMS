<?php

namespace App\Models\Vehicle;

use App\Models\Trip\TripMaterialModel;
use App\Models\Trip\TripPersonsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Support\Str;

class VehicleTemporaryRequestModel extends Model
{
    use SoftDeletes;

    protected $table = 'vehicle_requests_temporary'; // Specify the table name
    protected $primaryKey = 'request_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'requested_by_id',
        'assigned_vehicle_id',
        'requested_by',
        'approved_by',
        'vehicle_type',
        'director_reject_reason',
        'assigned_by',
        'purpose',
        'vec_director_reject_reason',
        'start_location',
        'end_location',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'start_km',
        'end_km',
        'dir_approved_by',
        'director_reject_reason',
        'sim_approved_by',
        'vec_director_reject_reason',
        'driver_accepted_by',
        'vehicle_id',
        'allowed_distance_after_destination',
        'notes',
        'comment',
        'status',
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
    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function driverAcceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_accepted_by');
    }
    public function materials()
    {
        return $this->hasMany(TripMaterialModel::class, 'request_id');
    }
    public function peoples()
    {
        return $this->hasMany(TripPersonsModel::class, 'request_id');
    }

    // Other relations
}
