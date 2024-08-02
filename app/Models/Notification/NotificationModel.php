<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class NotificationModel extends Model
{
    use SoftDeletes;

    protected $table = 'notifications'; // Specify the table name
    protected $primaryKey = 'notification_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'user_id',
        'message',
        'is_read',
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
