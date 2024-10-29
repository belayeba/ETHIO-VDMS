<?php

namespace App\Models\Vehicle;

use App\Http\Controllers\Vehicle\GivingBackPermanentVehicle;
use App\Models\User;
use App\Models\Vehicle\VehiclesModel as VehicleVehiclesModel;
use App\Models\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VehiclePermanentlyRequestModel extends Model {
    use SoftDeletes;

    protected $table = 'vehicle_requests_parmanently';
    // Specify the table name
    protected $primaryKey = 'vehicle_request_permanent_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'vehicle_id',
        'requested_by',
        'fuel_quata',
        'feul_left_from_prev',
        'position_letter',
        'purpose',
        'approved_by',
        'director_reject_reason',
        'given_by',
        'vec_director_reject_reason',
        'given_date',
        'mileage',
        'inspection_id',
        'accepted_by_requestor',
        'reject_reason_by_requestor',
        'status', // Vehicle Returned or not,
        'created_at'
    ];
    protected static function boot() {
        parent::boot();
        static::creating( function ( $model ) {
            if ( empty( $model-> {
                $model->getKeyName()}
            ) ) {
                $model-> {
                    $model->getKeyName()}
                    = ( string ) Str::uuid();
                }
            }
        );
    }

    public function vehicle(): BelongsTo {
        return $this->belongsTo( VehicleVehiclesModel::class, 'vehicle_id' );
    }

    public function requestedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'requested_by' );
    }

    public function approvedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'approved_by' );
    }

    public function accepted_by(): BelongsTo {
        return $this->belongsTo( User::class, 'accepted_by_requestor' );
    }

    public function inspection(): BelongsTo {
        return $this->belongsTo( InspectionModel::class, 'inspection_id' );
    }
    public function get_return():HasMany{
        return $this->hasMany( GivingBackVehiclePermanently::class, 'vehicle_request_permanent_id','permanent_request' );
    }

}
