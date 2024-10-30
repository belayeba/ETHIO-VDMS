<?php

namespace App\Models\Trip;

use App\Models\User;
use App\Models\Vehicle\VehicleTemporaryRequestModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TripPersonsModel extends Model
{
    use SoftDeletes;

    protected $table = 'trip_person';

    // Specify the table name
    protected $primaryKey = 'trip_person_id';

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'request_id',
        'employee_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{
                $model->getKeyName()}
            )) {
                $model->{
                    $model->getKeyName()}
                = (string) Str::uuid();
            }
        }
        );
    }

    public function vehicleRequestTemporary(): BelongsTo
    {
        return $this->belongsTo(VehicleTemporaryRequestModel::class, 'request_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
