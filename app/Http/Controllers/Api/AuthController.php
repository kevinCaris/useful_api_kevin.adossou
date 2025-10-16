<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function Register(RegisterRequest $request):JsonResponse{

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            "id"=> $user->id,
            "name"=>$user->name,
            "email"=>$user->email,
            "created_at"=>$user->created_at
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        Log::info($request);
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'invalid credentials',
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('my-app-token')->plainTextToken;

        return response()->json([
            "token" =>$token,
            "user_id" => $user->id
        ],200);
    }

}
