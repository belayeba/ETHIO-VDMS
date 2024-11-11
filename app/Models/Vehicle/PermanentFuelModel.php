<?php

namespace App\Models\Vehicle;

use App\Models\Driver\DriversModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PermanentFuelModel extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'permanent_fuelings';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $ffueling_idillable = [
        '',
        'driver_id',
        'vehicle_id',
        'finance_approved_by',
        'permanent_id',
        'reject_reason',
        'fuiling_date',
        'month',
        'year',
        'fuel_amount',
        'fuel_cost',
        'reciet_attachment',
        'created_at'
    ];
    protected static function boot()
        {
            parent::boot();

            static::creating(function ($model) {
                if (!$model->fueling_id) {
                    $model->fueling_id = (string) Str::uuid();
                }
            });
        }
    public function vehicle() {
        return $this->belongsTo( VehiclesModel::class, 'vehicle_id', 'vehicle_id' );
    }
    public function driver() {
        return $this->belongsTo( DriversModel::class, 'driver_id', 'driver_id' );
    }
    public function financeApprover() {
        return $this->belongsTo( User::class, 'finance_approved_by', 'id' );
    }
    public function permanentRequest() {
        return $this->belongsTo( VehiclePermanentlyRequestModel::class, 'permanent_id', 'vehicle_request_permanent_id' );
    }
}
