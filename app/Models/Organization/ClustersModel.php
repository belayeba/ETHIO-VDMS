<?php

namespace App\Models\Organization;

use App\Models\Organization\DepartmentsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ClustersModel extends Model
{
    use HasFactory;

    protected $table = 'clusters'; // Specify the table name
    protected $primaryKey = 'cluster_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->cluster_id)) {
                $model->cluster_id = (string) Str::uuid();
            }
        });
    }
    
    protected $fillable = [
        'name',
        'created_by'
    ];

    public function departments(): HasMany
    {
        return $this->hasMany(DepartmentsModel::class, 'cluster_id');
    }
}