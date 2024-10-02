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
        'approved_by',
        'reject_reason_director',
        'requested_by',
        'received_by',
        'reject_reason_vec_dire',
        'returned_date',
        'vehicle_request_id',
        'vehicle_detail_id',
        'status'
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
