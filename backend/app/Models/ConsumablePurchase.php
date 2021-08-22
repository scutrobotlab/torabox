<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsumablePurchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'consumable_purchases';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'consumable_id',
        'user_id',
        'number',
        'description',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $attributes = [
        'number' => 0,
    ];

    public function consumable()
    {
        return $this->belongsTo(Consumable::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateConsumable()
    {
        $this->consumable->increment('number', $this->number);
    }

    public function revertConsumable()
    {
        $this->consumable->decrement('number', $this->number);
    }
}
