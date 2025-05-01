<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = User::all();
        return $games;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:20',
            'name' => 'nullable|string|max:255',
            'password' => 'required|string|max:20',
        ]);

        // Hash the password before creating the user
        $userData = array_merge($validated, [
            'password' => Hash::make($validated['password']),
        ]);

        User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json(['message' => 'User Added'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
