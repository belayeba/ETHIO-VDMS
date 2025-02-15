<?php

namespace App\Models\Vehicle;

use App\Models\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Vehicle\VehiclesModel as VehicleVehiclesModel;
use Illuminate\Support\Str;

class MaintenancesModel extends Model {
    use SoftDeletes;

    protected $table = 'maintenances';
    // Specify the table name
    protected $primaryKey = 'maintenance_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'vehicle_id',
        'requested_by',
        'approved_by',
        'director_reject_reason',
        'inspected_by',
        'car_inspector_inspection',
        'inspector_comment',
        'sim_approved_by',
        'simirit_reject_reason',
        'maintained_by',
        'maintenance_type',
        'description',
        'status',
        'vehicle_detail_id',
        'cost',
        'parts_used',
        'mentained_date',
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

    public function requestedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'requested_by' );
    }

    public function approvedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'approved_by' );
    }

    public function maintainedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'maintained_by' );
    }

    public function inspectedBy(): BelongsTo {
        return $this->belongsTo( User::class, 'inspected_by' );
    }
}
