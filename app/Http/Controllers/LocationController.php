<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ClientLocation;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    // store client location (called from client-side JS)
    public function store(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        // find client via authenticated user (or send client_id explicitly if desired)
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $client = $user->client;
        if (!$client) {
            return response()->json(['error' => 'Client profile not found'], 404);
        }

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        // insert location row
        $location = ClientLocation::create([
            'client_id' => $client->id,
            'user_id' => $user->id,
            'lat' => $lat,
            'lng' => $lng,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'recorded_at' => now(),
        ]);

        // update clients quick columns
        $client->update([
            'last_lat' => $lat,
            'last_lng' => $lng,
            'last_seen_at' => now(),
        ]);

        return response()->json(['status' => 'ok', 'location_id' => $location->id]);
    }
}
