<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class userInfo extends Model
{
    use HasFactory;
    protected $primaryKey = 'info_id';
    public $incrementing = false;

    protected $keyType = 'uuid';
    protected $table = 'users_info';

   
    protected $fillable = [
        'info_id',
        'name',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->info_id) {
                $model->info_id = (string) Str::uuid();
            }
        });
    }


}
