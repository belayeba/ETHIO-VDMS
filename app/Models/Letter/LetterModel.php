<?php

namespace App\Models\Letter;

use App\Models\User;
use App\Models\Vehicle\VehiclesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterModel extends Model
{
    use SoftDeletes;

    /** 
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'letters';
    protected $primaryKey = 'letter_id';

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'uuid';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'new_vehicle_id',
        'letter_file',
        'department',
        'prepared_by',
        'reviewed_by',
        'reviewed_by_reject_reason',
        'approved_by',
        'approved_by_reject_reason',
        'accepted_by',
        'accepted_by_reject_reason',
        'status',
        'created_at'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
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

    /**
     * Get the vehicle associated with the letter.
     *
     * @return BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehiclesModel::class, 'new_vehicle_id', 'vehicle_id');
    }

    /**
     * Get the user who prepared the letter.
     *
     * @return BelongsTo
     */
    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by', 'id');
    }

    /**
     * Get the user who reviewed the letter.
     *
     * @return BelongsTo
     */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }

    /**
     * Get the user who approved the letter.
     *
     * @return BelongsTo
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    /**
     * Get the user who accepted the letter.
     *
     * @return BelongsTo
     */
    public function acceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by', 'id');
    }
}
