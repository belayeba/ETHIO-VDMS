<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClustersModel extends Model
{
    use HasFactory;

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
}
