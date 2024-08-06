<?php

namespace App\Models\Vehicle;

use App\Models\User;
use App\Models\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VehiclePermanentlyRequestModel extends Model
{
    use SoftDeletes;

    protected $table = 'vehicle_requests_parmanently'; // Specify the table name
    protected $primaryKey = 'vehicle_request_permanent_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'vehicle_id',
        'requested_by',
        'position_letter',
        'purpose',
        'approved_by',
        'given_by',
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
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehiclesModel::class, 'vehicle_id');
    }
    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

}
