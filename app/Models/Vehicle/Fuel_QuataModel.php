<?php

namespace App\Models\Vehicle;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Fuel_QuataModel extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'fuel_quata_id';
    protected $table = 'fuel_quatas';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'vehicle_id',
        'old_quata',
        'new_quata',
        'changed_by',
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

    // Relationship to Vehicle
    public function vehicle()
    {
        return $this->belongsTo(VehiclesModel::class, 'vehicle_id', 'vehicle_id');
    }

    // Relationship to User who changed the quata
    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');
    }
}
