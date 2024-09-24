<?php

namespace App\Models\RouteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RouteUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'route_user';
    protected $primaryKey = 'route_user_id'; // UUID as primary key
    public $incrementing = false;            // Since it's not an auto-incrementing key
    protected $keyType = 'uuid';             // Primary key type

    protected $fillable = [
        'route_user_id',
        'employee_id',
        'route_id',
        'registered_by',
    ];

    // Relationship to User model (employee)
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    // Relationship to Route model
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }

    // Relationship to User model (the person who registered the assignment)
    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by', 'id');
    }
}
