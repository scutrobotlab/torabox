<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
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
        'refresh_token',
    ];
    protected $hidden = [
        'deleted_at',
        'refresh_token',
    ];

    public function privileges()
    {
        return $this->hasMany(Privilege::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'privileges', 'user_id', 'group_id')->withPivot('privilege');
    }

    public function managedGroups()
    {
        return $this->belongsToMany(Group::class, 'privileges', 'user_id', 'group_id')->withPivot('privilege')->wherePivot('privilege', 2);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function isGroupUser($group_id)
    {
        return null != Privilege::where([
            ['user_id', $this->id],
            ['group_id', $group_id],
        ])->first();
    }

    public function isGroupMember($group_id)
    {
        return null != Privilege::where([
            ['user_id', $this->id],
            ['group_id', $group_id],
            ['privilege', 1],
        ])->first();
    }

    public function isGroupLeader($group_id)
    {
        return null != Privilege::where([
            ['user_id', $this->id],
            ['group_id', $group_id],
            ['privilege', 2],
        ])->first();
    }

    public static function storeOauthUserinfo($json, $refresh_token)
    {
        $user = User::updateOrCreate(
            ['uuid' => $json['uuid']],
            [
                'name' => $json['name'],
                'email' => $json['email'],
                'refresh_token' => $refresh_token,
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

    public static function getOauthToken($grant_type, $auth)
    {
        if ($grant_type == 'authorization_code') {
            $response = Http::get(config('oauth.url') . '/api/oauth/token', [
                'grant_type' => 'authorization_code',
                'client_id' => config('oauth.id'),
                'client_secret' => config('oauth.secret'),
                'redirect_uri' => config('app.url') . '/user/callback',
                'code' => $auth,
            ]);
        } else if ($grant_type == 'refresh_token') {
            $response = Http::get(config('oauth.url') . '/api/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $auth,
            ]);
        } else {
            return [
                'success' => false,
                'message' => 'no grant_type',
            ];
        }

        if ($response->failed()) {
            return [
                'success' => false,
                'message' => $response->body()
            ];
        }

        return [
            'success' => true,
            'message' => $response->json()
        ];
    }

    public static function getOauthUserinfo($access_token)
    {
        $response = Http::get(config('oauth.url') . '/api/oauth/userinfo', [
            'access_token' => $access_token,
        ]);
        if ($response->failed()) {
            return [
                'success' => false,
                'message' => $response->body()
            ];
        }
        return [
            'success' => true,
            'message' => $response->json()
        ];
    }

    public static function getAndStoreUserinfo($resp)
    {
        $access_token = $resp['message']['access_token'];
        $refresh_token = $resp['message']['refresh_token'];
        $expires_in = $resp['message']['expires_in'];

        $resp = User::getOauthUserinfo($access_token);
        if (!$resp['success']) {
            return [
                'success' => false,
                'message' => $resp['message'],
            ];
        }

        $user = User::storeOauthUserinfo($resp['message'], $refresh_token);
        Cache::put('user' . $user->uuid, $access_token, now()->addSeconds($expires_in - 60));

        return [
            'success' => true,
            'message' => $user,
        ];
    }

    public static function newOauthUserinfo($code)
    {
        $resp = User::getOauthToken('authorization_code', $code);
        if (!$resp['success']) {
            return [
                'success' => false,
                'message' => $resp['message'],
            ];
        }

        $resp = User::getAndStoreUserinfo($resp);
        if (!$resp['success']) {
            return [
                'success' => false,
                'message' => $resp['message'],
            ];
        }

        return [
            'success' => true,
            'message' => $resp['message'],
        ];
    }

    public static function updateOauthUserinfo($uuid, $refresh_token)
    {
        if (Cache::has('user' . $uuid)) {
            $access_token = Cache::get('user' . $uuid);
            $resp = User::getOauthUserinfo($access_token);
            if ($resp['success']) {
                $user = User::storeOauthUserinfo($resp['message'], $refresh_token);
                return [
                    'success' => true,
                    'message' => $user,
                ];
            }
        }

        $resp = User::getOauthToken('refresh_token', $refresh_token);
        if (!$resp['success']) {
            return [
                'success' => false,
                'message' => $resp['message'],
            ];
        }

        $resp = User::getAndStoreUserinfo($resp);
        if (!$resp['success']) {
            return [
                'success' => false,
                'message' => $resp['message'],
            ];
        }

        return [
            'success' => true,
            'message' => $resp['message'],
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
