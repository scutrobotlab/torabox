<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImmovableApplication extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'immovable_applications';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'immovable_id',
        'applicant_id',
        'approver_id',
        'action',
        'status',
        'description',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $attributes = [
        'action' => 'lend',
        'status' => 0,
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function group()
    {
        return $this->immovable->group();
    }

    public function updateImmovable()
    {
        if ($this->status != 1) {
            return;
        }
        if ($this->action = 'lend') {
            $this->immovable->status = 1;
            $this->immovable->owner_id = $this->applicant_id;
        } else {
            $this->immovable->status = 0;
            $this->immovable->owner_id = null;
        }
        $this->immovable->save();
    }
}
