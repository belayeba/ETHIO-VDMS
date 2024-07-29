<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class DriversModel extends Model
{
    use SoftDeletes;

    protected $table = 'drivers'; // Specify the table name
    protected $primaryKey = 'driver_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'user_id',
        'register_by',
        'license_number',
        'name',
        'contact',
        'address',
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'register_by');
    }
}
