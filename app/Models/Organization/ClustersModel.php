<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClusClustersModelter extends Model
{
    use SoftDeletes;

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

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'cluster_id');
    }
}
