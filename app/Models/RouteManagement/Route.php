<?php

namespace App\Models\RouteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'routes';
    protected $primaryKey = 'route_id'; // UUID as primary key
    public $incrementing = false;       // Since it's not an auto-incrementing key
    protected $keyType = 'uuid';        // Primary key type

    protected $fillable = [
        'route_id',
        'route_name',
        'driver_phone',
        'vehicle_id',
        'registered_by',
    ];

    // Relationship to Vehicle model
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }

    // Relationship to RouteUser model
    public function routeUsers()
    {
        return $this->hasMany(RouteUser::class, 'route_id', 'route_id');
    }

    // Relationship to User (the person who registered the route)
    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by', 'id');
    }
}
