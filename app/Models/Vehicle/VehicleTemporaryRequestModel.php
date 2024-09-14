<?php

namespace App\Models\Vehicle;

use App\Models\Trip\TripMaterialModel;
use App\Models\Trip\TripPersonsModel;
use App\Models\User;
use App\Models\Vehicle\VehicleInspection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
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
        'vehicle_type',
        'purpose',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'in_out_town',
        'start_km',
        'end_km',
        'status',
        'how_many_days',
        'with_driver',
        'vehicle_id',
        'dir_approved_by',
        'director_reject_reason',
        'div_approved_by',
        'cluster_director_reject_reason',
        'hr_div_approved_by',
        'hr_director_reject_reason',
        'assigned_by',
        'assigned_by_reject_reason',
        'transport_director_id',
        'vec_director_reject_reason',
        'start_location',
        'end_locations',
        'allowed_distance_after_destination',
        'notes',
        'comment',
        'km_per_liter',
        'driver_accepted_by',
        'taking_inspection',
        'returning_inspection',
        'created_at',
        'updated_at',
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
        return $this->belongsTo(User::class, 'requested_by_id','id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dir_approved_by');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function driverAcceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_accepted_by');
    }

    public function takingInspection(): BelongsTo
    {
        return $this->belongsTo(InspectionModel::class, 'taking_inspection', 'inspection_id');
    }

    public function returningInspection(): BelongsTo
    {
        return $this->belongsTo(InspectionModel::class, 'returning_inspection', 'inspection_id');
    }

    public function materials()
    {
        return $this->hasMany(TripMaterialModel::class, 'request_id');
    }

    public function peoples()
    {
        return $this->hasMany(TripPersonsModel::class, 'request_id');
    }

    public function scopeByCluster($query)
        {
            $userId = Auth::id();
            $user = User::with('department')->find($userId);
            $clusterId = $user->department->cluster_id;

            return $query->whereHas('requestedBy', function ($q) use ($clusterId) {
                $q->where('cluster_id', $clusterId);
            });
        }
}
