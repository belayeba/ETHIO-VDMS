<?php

namespace App\Models\Trip;

use App\Models\Vehicle\VehicleTemporaryRequestModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripMaterialModel extends Model
{
    use SoftDeletes;

    protected $table = 'trip_materials'; // Specify the table name
    protected $primaryKey = 'trip_material_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'request_id',
        'material_name',
        'material_weight',
        'created_at',
        'updated_at'
    ];

    public function vehicleRequestTemporary(): BelongsTo
        {
            return $this->belongsTo(VehicleTemporaryRequestModel::class, 'request_id');
        }
}
