<?php

namespace App\Models;

use App\Models\Driver\DriversModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelsModel extends Model
{
    use SoftDeletes;

    protected $table = 'fuelings'; // Specify the table name
    protected $primaryKey = 'fueling_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'approved_by',
        'service_given_by',
        'location_id',
        'amount',
        'created_at',
        'updated_at'
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehiclesModel::class, 'vehicle_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(DriversModel::class, 'driver_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function serviceGivenBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'service_given_by');
    }
}
