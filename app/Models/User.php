<?php

namespace App\Models;

use App\Models\Communication\DriverCommunicationModel;
use App\Models\Driver\DriversModel;
use App\Models\Notification\NotificationModel;
use App\Models\Vehicle\VehicleTemporaryRequestModel;
use App\Models\Vehicle\MaintenancesModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasFactory;

    protected $table = 'users'; // Specify the table name
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function drivers(): HasMany
    {
        return $this->hasMany(DriversModel::class, 'user_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(NotificationModel::class, 'user_id');
    }

    public function driverCommunications(): HasMany
    {
        return $this->hasMany(DriverCommunicationModel::class, 'user_id');
    }

    public function requestedVehicleRequests(): HasMany
    {
        return $this->hasMany(VehicleTemporaryRequestModel::class, 'requested_by_id');
    }

    public function approvedVehicleRequests(): HasMany
    {
        return $this->hasMany(VehicleTemporaryRequestModel::class, 'approved_by');
    }

    public function assignedVehicleRequests(): HasMany
    {
        return $this->hasMany(VehicleTemporaryRequestModel::class, 'assigned_by');
    }

    public function registeredDrivers(): HasMany
    {
        return $this->hasMany(DriversModel::class, 'register_by');
    }

    public function maintainedVehicles(): HasMany
    {
        return $this->hasMany(MaintenancesModel::class, 'maintained_by');
    }

}
