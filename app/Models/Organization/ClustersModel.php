<?php

namespace App\Models\Organization;

use App\Models\DepartmentsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ClustersModel extends Model
{
    // use SoftDeletes;

    protected $table = 'clusters'; // Specify the table name
    protected $primaryKey = 'cluster_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'cluster_id',
        'name',
        'description',
        'created_at',
        'updated_at'
    ];

    public function departments():HasMany
    {
        return $this->hasMany(DepartmentsModel::class, 'cluster_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
