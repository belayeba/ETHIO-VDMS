<?php

namespace App\Models\Organization;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

// use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentsModel extends Model
{
    use HasFactory;

    protected $table = 'departments';

    // Specify the table name
    protected $primaryKey = 'department_id';

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'cluster_id',
        'name',
        'created_by',
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

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(ClustersModel::class, 'cluster_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }
}
