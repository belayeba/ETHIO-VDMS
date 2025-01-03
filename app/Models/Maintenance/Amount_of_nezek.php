<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Model;

class Amount_of_nezek extends Model
{
    protected $table = 'amount_of_nezek_useds';
    protected $primaryKey = 'amount_of_nezek_used_id';
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
        'amount_of_nezek_used_id',
        'maintained_vehicle_id',
        'amount_of_nezek',
        'type_of_nezek',
        'created_at'
    ];
    public function maintained_vehicle(): BelongsTo {
        return $this->belongsTo( Maintained_vehicle::class);
    }
}