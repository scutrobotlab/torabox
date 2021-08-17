<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'groups';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'privileges', 'group_id', 'user_id')->withPivot('privilege');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'privileges', 'group_id', 'user_id')->withPivot('privilege')->wherePivotIn('privilege', [1, 2]);
    }

    public function leaders()
    {
        return $this->belongsToMany(User::class, 'privileges', 'group_id', 'user_id')->withPivot('privilege')->wherePivot('privilege', 2);
    }
}
