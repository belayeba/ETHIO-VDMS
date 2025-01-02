<?php

namespace App\Models\Vehicle;

use App\Models\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Maintenance\Maintenance_record;
use App\Models\Vehicle\VehiclesModel as VehicleVehiclesModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Vehicle\InspectionModel;

class MaintenancesModel extends Model {
    use SoftDeletes;

    protected $table = 'maintenances';
    // Specify the table name
    protected $primaryKey = 'maintenance_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'maintenance_id',
        'vehicle_id',
        'requested_by',
        'approved_by',
        'drivers_inspection',
        'taking_inspection',
        'director_rejection_reason',
        'sim_approved_by',
        'maintenance_type',
        'maintenance_status',
        'notes',
        'approved_by',
        'milage',
        'simirit_reject_reason'
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

public function maintenance_record(): HasMany {

    return $this->hasMany( Maintenance_record::class, 'maintenance_record_id','maintenance_id' );
}
    public function vehicle(): BelongsTo {
        return $this->belongsTo( VehicleVehiclesModel::class,'vehicle_id', 'vehicle_id' );
    }

    public function requestedBy(): BelongsTo {
        return $this->belongsTo( User::class,'id', 'requested_by' );
    }

    public function approvedBy(): BelongsTo {

        return $this->belongsTo( User::class,'id', 'approved_by' );
    }
    public function taking_inspection() : BelongsTo {

        return $this->belongsTo(InspectionModel::class,'inspection_id', 'taking_inspection');

    }
  
}
