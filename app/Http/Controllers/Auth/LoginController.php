<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'uuid' => ['required','max:255'],
            'app_id' => ['required','max:255'],
            'language' => ['required','max:255'],
            'os' => ['required','max:255'],
        ]);
        $device = Devices::updateOrCreate(
            ['uuid' => $request->uuid],
            ['app_id' => $request->app_id,'language'=> $request->language,'os'=> $request->os]
        );

        return response()->json([
            'access_token' => $device->createToken($request->app_id)->plainTextToken
        ], 201);
    }
}
