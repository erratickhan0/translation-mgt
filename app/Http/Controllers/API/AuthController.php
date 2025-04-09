<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Login method to authenticate and return a simple auth token
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Create and return the token
        $token = $user->createToken('translationServiceToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => now()->addMinutes(30)->toDateTimeString(),
        ]);
    }

    // Token refresh method to issue a new token
    public function refreshToken(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        // Extract token ID from bearer token
        $tokenId = explode('|', $token, 2)[0] ?? null;
        if (!$tokenId) {
            return response()->json(['message' => 'Invalid token format'], 401);
        }

        // Retrieve the token record from the database
        $tokenRecord = DB::table('personal_access_tokens')->find($tokenId);

        if (!$tokenRecord) {
            return response()->json(['message' => 'Token not found'], 401);
        }

        // Find the user associated with the token
        $user = User::find($tokenRecord->tokenable_id);

        // Revoke the old token
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        // Create a new token and return it
        $newToken = $user->createToken('translationServiceToken')->plainTextToken;

        return response()->json([
            'access_token' => $newToken,
            'token_type' => 'Bearer',
            'expires_at' => now()->addMinutes(30)->toDateTimeString(),
        ]);
    }

    // Logout method to revoke the token
    public function logout(Request $request)
    {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
