<?php

namespace App\Models\Vehicle;

use App\Models\Driver\DriversModel;
use App\Models\User;
use App\Models\Vehicle\FuelsModel;
use App\Models\Vehicle\MaintenancesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VehiclesModel extends Model {
    use SoftDeletes;

    protected $table = 'vehicles';
    // Specify the table name
    protected $primaryKey = 'vehicle_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'vin', 'make', 'model', 'year', 'plate_number', 'registered_by', 'mileage', 'vehicle_type',
        'vehicle_category', 'fuel_amount', 'last_service', 'libre', 'insurance','rental_type',
        'next_service', 'driver_id', 'capacity','inspection_id', 'fuel_type', 'status', 'notes', 'created_at',
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

    public function maintenances(): HasMany {
        return $this->hasMany( MaintenancesModel::class, 'vehicle_id' );
    }

    public function requestedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'requested_by_id' );
    }

    public function fuelings(): HasMany {
        return $this->hasMany( FuelsModel::class, 'vehicle_id' );
    }

    public function driver():BelongsTo {
        return $this->belongsTo( DriversModel::class, 'driver_id', 'driver_id' );
    }

    public function inspection():BelongsTo {
        return $this->belongsTo( InspectionModel::class, 'inspection_id', 'inspection_id' );
    }
    // Other relations
}
