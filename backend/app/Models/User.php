<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'uuid',
        'name',
        'email',
    ];
    protected $hidden = [
        'deleted_at',
    ];

    public function privileges()
    {
        return $this->hasMany(Privilege::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'privileges', 'user_id', 'group_id')->withPivot('privileges');
    }

    public function isGroupLeader($group_id)
    {
        return null != Privilege::where([
            ['user_id', $this->id],
            ['group_id', $group_id],
            ['privilege', 2],
        ])->first();
    }
}
