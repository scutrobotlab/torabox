<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ConfigController extends Controller
{
    public function list(Request $request)
    {
        return response()->json([
            'oauth_url' => config('oauth.url'),
            'oauth_client_id' => config('oauth.id'),
            'is_production' => !App::environment(['local', 'staging']),
        ]);
    }
}
