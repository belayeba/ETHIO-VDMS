<?php

namespace App\Models\Vehicle;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReplacementModel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'replacements';

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'uuid';
    protected $primaryKey = 'replacement_id';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'new_vehicle_id',
        'permanent_id',
        'register_by',
        'status',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
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

    /**
     * Get the new vehicle associated with the replacement.
     *
     * @return BelongsTo
     */
    public function newVehicle(): BelongsTo
    {
        return $this->belongsTo(VehiclesModel::class, 'new_vehicle_id', 'vehicle_id');
    }

    /**
     * Get the permanent vehicle request associated with the replacement.
     *
     * @return BelongsTo
     */
    public function permanentRequest(): BelongsTo
    {
        return $this->belongsTo(VehiclePermanentlyRequestModel::class, 'permanent_id', 'vehicle_request_permanent_id');
    }
    /**
     * Get the user who registered the replacement.
     *
     * @return BelongsTo
     */
    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'register_by', 'id');
    }
}
