<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AuthenticateController extends Controller
{
   /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'could not create token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function test(Request $request)
    {
        dd(JWTAuth::toUser($request->token));
    }
}
