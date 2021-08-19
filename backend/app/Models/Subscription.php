<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'user_id',
        'group_id',
        'end_time',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
