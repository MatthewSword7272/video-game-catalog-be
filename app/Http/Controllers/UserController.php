<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:20',
        ]);


        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json(['message' => 'User Added'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        // Check if this is a verification request (from /users/verify endpoint)
        if ($request->routeIs('users.verify')) {
            Log::info('User verification request');

            $validated = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $username = $validated['username'];
            $password = $validated['password'];

            Log::info("Attempting to verify user: {$username}");

            // Find user by username
            $user = User::where('username', $username)->first();

            if (!$user) {
                Log::info("User not found: {$username}");
                return response()->json(['message' => 'User not found'], 404);
            }

            // Verify password
            if (!Hash::check($password, $user->password)) {
                Log::info("Invalid password for user: {$username}");
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            Log::info("User verified successfully: {$username}");
            return response()->json($user);
        }

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
