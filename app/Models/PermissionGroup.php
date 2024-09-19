<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Permission;

class PermissionGroup extends Model {
    use HasFactory;

    protected $table = 'permission_groups';
    // Specify the table name
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public function permissions() {
        return $this->hasMany( Permission::class, 'group_id', 'id' );
    }
}
