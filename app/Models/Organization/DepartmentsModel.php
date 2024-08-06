<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DepartmentsModel extends Model
{
    use SoftDeletes;

    protected $table = 'departments'; // Specify the table name
    protected $primaryKey = 'department_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'department_id',
        'cluster_id',
        'name',
        'description',
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
    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class, 'cluster_id');
    }
}
