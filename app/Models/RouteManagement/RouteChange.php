<?php

namespace App\Models\RouteManagement;

use App\Models\User;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class RouteChange extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'routechanges';
    protected $primaryKey = 'route_change_id'; // UUID as primary key
    public $incrementing = false;       // Since it's not an auto-incrementing key
    protected $keyType = 'uuid';        // Primary key type

    protected $fillable = [
        'route_id',
        'older_driver_phone',
        'older_vehicle_id',
        'registered_by',
    ];
    protected static function boot()
        {
            parent::boot();

            static::creating(function ($model) {
                if (empty($model->route_change_id)) {
                    $model->route_change_id = (string) Str::uuid();
                }
            });
        }
    // Relationship to Vehicle model
    public function vehicle()
        {
            return $this->belongsTo(VehiclesModel::class, 'older_vehicle_id', 'vehicle_id');
        }

    // Relationship to RouteUser model
    public function route()
        {
            return $this->belongsTo(Route::class, 'route_id', 'route_id');
        }
    // Relationship to User (the person who registered the route)
    public function registeredBy()
        {
            return $this->belongsTo(User::class, 'registered_by', 'id');
        }
}
