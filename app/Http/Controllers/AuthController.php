<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            // Find the user manually since we're using username not email
            $user = User::where('username', $credentials['username'])->first();
            
            if ($user && Hash::check($credentials['password'], $user->password)) {
                $token = $user->createToken('admin-token')->plainTextToken;
                
                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'token' => $token
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorrect.'
            ], 401);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function createDefaultAdmin()
    {
        $admin = User::firstOrCreate([
            'username' => 'admin'
        ], [
            'password' => Hash::make('admin123'),
            'is_admin' => true
        ]);

        return response()->json([
            'message' => 'Default admin created',
            'username' => 'admin',
            'password' => 'admin123'
        ]);
    }
}