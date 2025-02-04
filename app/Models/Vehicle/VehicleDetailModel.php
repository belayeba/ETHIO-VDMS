<?php

namespace App\Models;

use App\Models\Vehicle\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VehicleDetailModel extends Model {
    use SoftDeletes;

    protected $table = 'vehicles_detail';
    // Specify the table name
    protected $primaryKey = 'detail_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'vehicle_id',
        'detail',
        'register_by',
        'date',
        'driver_id',
        'mileage'
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
}
