<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsumableApplication extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'consumable_applications';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $perPage = 7;
    protected $fillable = [
        'consumable_id',
        'applicant_id',
        'approver_id',
        'number',
        'status',
        'description',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $attributes = [
        'number' => 0,
        'status' => 0,
    ];

    public function consumable()
    {
        return $this->belongsTo(Consumable::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function updateConsumable()
    {
        if ($this->status == 1) {
            $this->consumable->decrement('number', $this->number);
        }
    }

    public function revertConsumable()
    {
        $this->consumable->increment('number', $this->number);
    }
}
