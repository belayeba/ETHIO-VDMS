<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentsModel extends Model
{
    use HasFactory;

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

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class, 'cluster_id');
    }
}
