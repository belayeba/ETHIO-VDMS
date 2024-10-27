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
    protected $primaryKey = 'fueling_id,month,driver_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'fueling_id',
        'driver_id',
        'finance_approved_by',
        'permanent_id',
        'reject_reason',
        'fuiling_date',
        'month',
        'fuel_amount',
        'fuel_cost',
        'reciet_attachment',
        'created_at'
    ];
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
