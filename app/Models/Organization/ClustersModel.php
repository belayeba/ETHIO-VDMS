<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

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
        'cluster_id',
        'name',
        'description',
        'created_at',
        'updated_at'
    ];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'cluster_id');
    }
}
