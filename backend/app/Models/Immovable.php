<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Immovable extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'immovables';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'uuid',
        'name',
        'immovable_kind_id',
        'user_id',
        'need_approval',
        'status',
        'owner_id',
        'description',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $attributes = [
        'status' => 0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function kind()
    {
        return $this->belongsTo(ImmovableKind::class, "immovable_kind_id", "id");
    }

    public function applications()
    {
        return $this->hasMany(ImmovableApplication::class);
    }

    public function group()
    {
        return $this->kind->group();
    }

    public function approvers()
    {
        return $this->group->leaders();
    }
}
