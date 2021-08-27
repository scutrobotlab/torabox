<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumable extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'consumables';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'uuid',
        'name',
        'number',
        'user_id',
        'group_id',
        'need_approval',
        'description',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $attributes = [
        'number' => 0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function applications()
    {
        return $this->hasMany(ConsumableApplication::class)->latest();
    }

    public function purchases()
    {
        return $this->hasMany(ConsumablePurchase::class)->latest();
    }

    public function approvers()
    {
        return $this->group->leaders();
    }
}
