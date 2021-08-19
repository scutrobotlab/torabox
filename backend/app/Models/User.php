<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;

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
        return $this->belongsToMany(Group::class, 'privileges', 'user_id', 'group_id')->withPivot('privilege');
    }

    public function isGroupLeader($group_id)
    {
        return null != Privilege::where([
            ['user_id', $this->id],
            ['group_id', $group_id],
            ['privilege', 2],
        ])->first();
    }

    public static function storeOauth($json)
    {
        $user = User::firstOrCreate(
            ['uuid' => $json['uuid']],
            [
                'uuid' => $json['uuid'],
                'name' => $json['name'],
                'email' => $json['email'],
            ]
        );

        $user->privileges()->delete();

        foreach ($json['groups'] as $group) {
            $user->privileges()->create([
                'user_id' => $user->id,
                'group_id' => $group['pivot']['group_id'],
                'privilege' => $group['pivot']['power'],
            ]);
        }

        $user->groups;
        $user->avatar = $json['avatar'];
        return $user;
    }

    public static function oauth($code)
    {
        $response1 = Http::get(config('oauth.url') . '/api/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('oauth.id'),
            'client_secret' => config('oauth.secret'),
            'redirect_uri' => config('app.url') . '/user/callback',
            'code' => $code,
        ]);
        if ($response1->failed()) {
            return [
                'success' => false,
                'message' => $response1->body()
            ];
        }

        $response2 = Http::get(config('oauth.url') . '/api/oauth/userinfo', [
            'access_token' => $response1->json()['access_token'],
        ]);
        if ($response2->failed()) {
            return [
                'success' => false,
                'message' => $response2->body()
            ];
        }
        return [
            'success' => true,
            'message' => $response2->json()
        ];
    }

    public static function fakeUsers()
    {
        return config('fakeusers.users');
    }

    public static function fakeOauth($id)
    {
        $users = User::fakeUsers();
        return $users[$id];
    }
}
