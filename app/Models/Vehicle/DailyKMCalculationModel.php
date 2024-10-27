<?php

namespace App\Models\vehicle;

use App\Models\Driver\DriversModel;
use App\Models\User;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DailyKMCalculationModel extends Model {
    use SoftDeletes;

    protected $table = 'daily_km_calculations';
    // Specify the table name
    protected $primaryKey = 'calculation_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'calculation_id',
        'vehicle_id',
        'driver_id',
        'morning_km',
        'afternoon_km',
        'register_by',
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
        return $this->belongsTo( VehiclesModel::class, 'vehicle_id' );
    }

    public function driver(): BelongsTo {
        return $this->belongsTo( DriversModel::class, 'driver_id' );
    }

    public function created_by(): BelongsTo {
        return $this->belongsTo( User::class, 'created_by', 'id' );
    }
}
