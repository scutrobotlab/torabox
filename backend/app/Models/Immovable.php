<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
    protected $appends = [
        'status_text',
    ];

    public static function findIdorUuid($id)
    {
        $immovable = null;
        if (Str::isUuid($id)) {
            $immovable = Immovable::where('uuid', $id)->firstOrFail();
        } else {
            $immovable = Immovable::findOrFail($id);
        }
        return $immovable;
    }

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
        return $this->hasMany(ImmovableApplication::class)->latest();
    }

    public function group()
    {
        return $this->kind->group();
    }

    public function approvers()
    {
        return $this->group->leaders();
    }

    public function getStatusTextAttribute()
    {
        $text = '';
        switch ($this->status) {
            case 0:
                $text = '在库';
                break;
            case 1:
                $text = $this->owner->name . '已借出';
                break;
            case -1:
                $text = '损坏';
                break;
            default:
                $text = '未知';
                break;
        }
        return $text;
    }
}
