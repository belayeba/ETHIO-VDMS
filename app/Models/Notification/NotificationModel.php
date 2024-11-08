<?php

namespace App\Models\Notification;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationModel extends Model
{
    use HasFactory;
    use HasUuids,SoftDeletes;

    protected $primaryKey = 'notification_id';

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'message',
        'is_read',
    ];

    // Define relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
