<?php

namespace App\Http\Controllers;

use App\Models\VideoGame;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class VideoGameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = VideoGame::all();
        return $games;
    }

    public function getUserGames(Request $request)
    {
        $userId = $request->input('user_id');

        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        $games = VideoGame::where('user_id', $userId)->get();
        return response()->json($games);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'developer' => 'required|string|max:255',
            'publisher' => 'string|max:255|nullable',
            'release_year' => 'required|integer',
            'platform' => 'required|string|max:100',
            'region_code' => 'required|string'
        ]);

        if (trim($validated['publisher']) === '') $validated['publisher'] = 'N/A';

        $title = trim($validated['title']);
        $auth_token = env('TWITCH_ACCESS_TOKEN');

        $imageData = Http::withHeaders([
            'Client-ID' => env('TWITCH_CLIENT_ID'),
            'Authorization' => "Bearer $auth_token"
        ])->withBody('fields cover.*, summary; where name = "'.$title.'";')->post('https://api.igdb.com/v4/games/');

        $newGame = array_merge($validated, [
            'user_id' => $request['user_id'],
            'description' => $imageData[0]['summary'] ?? 'N/A',
            'image' => $imageData[0]['cover']['image_id']
        ]);

        Log::info($newGame);

        VideoGame::create($newGame);

        return response()->json(['message' => 'Game Added'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(VideoGame $videoGame)
    {
        return $videoGame;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VideoGame $videoGame)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoGame $videoGame)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:50',
            'developer' => 'required|string|max:255',
            'publisher' => 'string|max:255',
            'release_year' => 'required|integer',
            'platform' => 'required|string|max:50',
            'region_code' => 'required|string'
        ]);

        $videoGame->update($validated);

        return response()->json(['message' => 'Game Updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoGame $videoGame)
    {
        $videoGame->delete();

        return response()->json(['message' => 'Game Deleted'], 200);

    }
}
