<?php

namespace App\Models\Organization;

use App\Models\DepartmentsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
<<<<<<< HEAD
use Illuminate\Support\Str;
// use Illuminate\Database\Eloquent\SoftDeletes;
=======
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
>>>>>>> cee9449d6d7bb55a104b42c6befe73c82ccbc7ab

class ClustersModel extends Model
{
    // use SoftDeletes;

    protected $table = 'clusters'; // Specify the table name
    protected $primaryKey = 'cluster_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'created_by',
        'description',
        'created_at',
        'updated_at'
    ];
    protected static function boot()
        {
            parent::boot();

<<<<<<< HEAD
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
=======
            static::creating(function ($model) {
                if (empty($model->{$model->getKeyName()})) {
                    $model->{$model->getKeyName()} = (string) Str::uuid();
                }
            });
        }
    public function departments(): HasMany
        {
            return $this->hasMany(DepartmentsModel::class, 'cluster_id');
        }
    public function Registered_by(): BelongsTo
        {
            return $this->belongsTo(User::class,'created_by','user_id');
        }
>>>>>>> cee9449d6d7bb55a104b42c6befe73c82ccbc7ab
}
