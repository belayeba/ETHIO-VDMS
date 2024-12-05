<?php

namespace App\Models\Vehicle;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FeulCosts extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'fuel_cost_id';
    protected $table = 'fuel_costs';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = [
        'new_cost',
        'changed_by',
        'fuel_type',
        'created_at'
    ];
    protected static function boot() {
        parent::boot();

        static::creating( function ( $model ) {
            if ( empty( $model-> {
                $model->getKeyName()}
            ) ) {
                $model-> {
                    $model->getKeyName()}
                    = ( string ) Str::uuid();
                }
            }
        );
    }
    // Relationship to User who changed the quata
    public function changer()
        {
            return $this->belongsTo(User::class, 'changed_by', 'id');
        }
}
