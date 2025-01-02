<?php

namespace App\Models\Maintenance;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Vehicle\MaintenancesModel;
use App\Models\Maintenance\Maintenance_record;
use App\Models\Maintenance\Items_for_next_maintenance;
use App\Models\Maintenance\Total_maintenance_cost;
use App\Models\Maintenance\Amount_of_nezek;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Maintained_vehicle extends Model
{
    protected $table = 'maintained_vehicles';
    protected $primaryKey = 'maintained_vehicle_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
  
    protected static function boot()
           {
    parent::boot();
    static::creating(function ($model) {
        if (empty($model->{$model->getKeyName()})) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        }
    });
}
protected $fillable = [
    'maintained_vehicle_id',
    'maintenance_id',
    'giving_inspection',
    'accepted_by',
    'maintenance_status',
    'card_number',
    'technician_description',
    'spareparts_used',
    'created_at'
];
public function maintained_vehicle(): HasMany {
    return $this->hasMany(Maintained_vehicle::class,'maintained_vehicle_id', 'maintained_vehicle_id');
}
public function user(): BelongsTo {
    return $this->belongsTo( User::class, 'user_id' );
}
public function maintenance(): BelongsTo {
    return $this->belongsTo(MaintenancesModel::class, 'maintenance_id','maintained_vehicle_id');
}
public function items_for_next_maintenance(): HasMany {
    return $this->hasMany(Items_for_next_maintenance::class);
}
public function total_maintenance_costs(): HasMany {
    return $this->hasMany(Total_maintenance_cost::class);
}
public function maintenance_records(): HasMany {
    return $this->hasMany(Maintenance_record::class);
}
public function amount_of_nezek(): HasMany {
    return $this->hasMany(Amount_of_nezek::class);
}
}
