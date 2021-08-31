<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImmovableKind extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'immovable_kinds';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'group_id',
        'description',
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function immovables()
    {
        return $this->hasMany(Immovable::class)->with('user');
    }
}
