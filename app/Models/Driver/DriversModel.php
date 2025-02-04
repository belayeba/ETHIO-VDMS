<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Support\Str;

class DriversModel extends Model {
    use SoftDeletes;

    protected $table = 'drivers';
    // Specify the table name
    protected $primaryKey = 'driver_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
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
    protected $fillable = [
        'user_id',
        'register_by',
        'license_number',
        'license_expiry_date',
        'license_file',
        'status',
        'phone_number',
        'notes',
        'created_at'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo( User::class, 'user_id' );
    }

    public function registeredBy(): BelongsTo {
        return $this->belongsTo( User::class, 'register_by' );
    }
}
