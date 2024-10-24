<?php

namespace App\Models\Vehicle;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VehiclePart extends Model
{
    use SoftDeletes;

    // Specify the primary key
    protected $primaryKey = 'vehicle_parts_id';
    public $incrementing = false;

    // Set the key type to string (UUIDs)
    protected $keyType = 'uuid';

    // Specify the table associated with the model
    protected $table = 'vehicle_parts';

    // Fields that can be mass-assigned
    protected $fillable = [
        'vehicle_parts_id',
        'name',
        'notes',
        'type',
        'created_by'
    ];

    // Automatically generate UUID for vehicle_parts_id if not provided
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->vehicle_parts_id) {
                $model->vehicle_parts_id = (string) Str::uuid();
            }
        });
    }
     // Relationship with the User (Inspector) model
     public function created_by()
     {
         return $this->belongsTo(User::class, 'created_by', 'id');
     }
 
}
