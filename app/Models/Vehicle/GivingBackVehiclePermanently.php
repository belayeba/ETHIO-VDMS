<?php

namespace App\Models\Vehicle;

use App\Models\User;
use App\Models\Vehicle\VehiclesModel as VehicleVehiclesModel;
use App\Models\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GivingBackVehiclePermanently extends Model {
    use SoftDeletes;

    protected $table = 'giving_back_vehicles_parmanently';
    // Specify the table name
    protected $primaryKey = 'giving_back_vehicle_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'vehicle_id',
        'purpose',
        'return_type',
        'approved_by',
        'reject_reason_vec_director',
        'requested_by',
        'received_by',
        'reject_reason_dispatcher',
        'returned_date',
        'inspection_id',
        'permanent_request',
        'status',
        'created_at'
    ];
    protected static function boot() {
        parent::boot();

        static::creating( function ( $model ) {
            if ( empty( $model-> {
                $model->getKeyName()}
            ) ) 
            {
                $model-> {
                    $model->getKeyName()}
                    = ( string ) Str::uuid();
            }
            }
        );
    }

    public function vehicle(): BelongsTo {
        return $this->belongsTo( VehicleVehiclesModel::class, 'vehicle_id','vehicle_id' );
    }

    public function permanentRequest(): BelongsTo {
        return $this->belongsTo( VehiclePermanentlyRequestModel::class, 'permanent_request' );
    }

    public function returnedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'returned_by' );
    }

    public function receivedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'received_by' );
    }
    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by','id');
    }
}
