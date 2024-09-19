<?php

namespace App\Models\Vehicle;

use App\Models\Driver\DriversModel;
use App\Models\User;
use App\Models\Vehicle\VehiclesModel as VehicleVehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FuelsModel extends Model {
    use SoftDeletes;

    protected $table = 'fuelings';
    // Specify the table name
    protected $primaryKey = 'fueling_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'approved_by',
        'vec_director_id',
        'vec_direct_reject_reason',
        'direct_reject_reason',
        'service_given_by',
        'fuelor_reject',
        'location_id',
        'fuel_amount',
        'fuel_cost',
        'fuiling_date',
        'notes'
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

    public function driver(): BelongsTo {
        return $this->belongsTo( DriversModel::class, 'driver_id' );
    }

    public function approvedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'approved_by' );
    }

    public function serviceGivenBy(): BelongsTo {
        return $this->belongsTo( User::class, 'service_given_by' );
    }
}
