<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;
    protected $table = 'privileges';
    protected $primaryKey = [
        'user_id',
        'group_id',
    ];
    public $incrementing = false;
    public $timestamps = true;
    protected $attributes = [
        'privilege' => 0,
    ];
    protected $fillable = [
        'user_id',
        'group_id',
        'privilege',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('user_id', $this->getAttribute('user_id'))->where('group_id', $this->getAttribute('group_id'));
    }
}
