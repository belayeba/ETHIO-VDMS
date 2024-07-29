<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GivingBackVehiclePermanently extends Model
{
    use SoftDeletes;

    protected $table = 'giving_back_vehicle_permanently'; // Specify the table name
    protected $primaryKey = 'giving_back_vehicle_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'giving_back_vehicle_id',
        'vehicle_id',
        'returned_by',
        'received_by',
        'status',
        'created_at',
        'updated_at'
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function returnedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
