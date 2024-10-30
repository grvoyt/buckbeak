<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\TokenResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request): TokenResource
    {
        $request->authenticate();

        $token = auth()->user()->createToken('default');

        return new TokenResource($token);
    }
}
