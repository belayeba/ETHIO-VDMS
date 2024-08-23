<?php

namespace App\Models\Vehicle;

use App\Models\User;
use App\Models\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class InspectionModel extends Model
{
    use SoftDeletes;

    // Set the primary key as a composite key
    protected $primaryKey = ['inspection_id', 'part_name','inspected_by'];
    public $incrementing = false;

    // Specify the table associated with the model
    protected $table = 'vehicle_inspections';

    // Set the key type to string (UUIDs)
    protected $keyType = 'uuid';

    // Fields that can be mass-assigned
    protected $fillable = [
        'inspection_id',
        'vehicle_id',
        'inspected_by',
        'part_name',
        'is_damaged',
        'damage_description',
        'inspection_date',
        'created_at',
        'updated_at'
    ];

    // Automatically generate UUID for inspection_id if not provided
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->inspection_id) {
                $model->inspection_id = (string) Str::uuid();
            }
        });
    }

    // Define relationships

    // Relationship with the Vehicle model
    public function vehicle()
    {
        return $this->belongsTo(VehiclesModel::class, 'vehicle_id', 'vehicle_id');
    }

    // Relationship with the User (Inspector) model
    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspected_by', 'id');
    }

    // Relationship with the VehiclePart model
    public function part()
    {
        return $this->belongsTo(VehiclePart::class, 'part_name', 'vehicle_parts_id');
    }
}
