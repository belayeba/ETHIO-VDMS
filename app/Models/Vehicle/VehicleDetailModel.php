<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class VehicleDetailModel extends Model
{
    use SoftDeletes;

    protected $table = 'vehicles_detail'; // Specify the table name
    protected $primaryKey = 'detail_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'detail_id',
        'vehicle_id',
        'detail_type',
        'detail_value',
        'created_at',
        'updated_at'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehiclesModel::class, 'vehicle_id');
    }
}
