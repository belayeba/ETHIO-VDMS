<?php

namespace App\Models\Trip;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Vehicle\VehicleTemporaryRequestModel;
class TripPersonsModel extends Model
{
    use SoftDeletes;

    protected $table = 'trip_people'; // Specify the table name
    protected $primaryKey = 'trip_person_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'request_id',
        'employee_id',
        'created_at',
        'updated_at'
    ];

    public function vehicleRequestTemporary(): BelongsTo
        {
            return $this->belongsTo(VehicleTemporaryRequestModel::class, 'request_id');
        }
    public function user(): BelongsTo
        {
            return $this->belongsTo(User::class, 'employee_id');
        }
}
