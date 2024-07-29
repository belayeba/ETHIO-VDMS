<?php

namespace App\Models\Vehicle;

use App\Models\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class MaintenancesModel extends Model
{
    use SoftDeletes;

    protected $table = 'maintenances'; // Specify the table name
    protected $primaryKey = 'maintenance_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'vehicle_id',
        'requested_by',
        'approved_by',
        'maintained_by',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehiclesModel::class, 'vehicle_id');
    }
    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function maintainedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'maintained_by');
    }
}
