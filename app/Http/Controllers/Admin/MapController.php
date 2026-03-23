<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ClientLocation;
use Carbon\Carbon;

class MapController extends Controller
{
    // show admin map page
    public function index()
    {
        return view('dashboard.admin.map');
    }

    // return recent client locations as JSON
    public function locations(Request $request)
    {
        // fetch latest location per client (using last_seen columns)
        $clients = Client::whereNotNull('last_lat')
                  ->select(['id','firstname','lastname','registration_id','last_lat','last_lng','last_seen_at'])
                  ->whereNotNull('last_lat')
                  ->get();

        $data = $clients->map(function($c){
            return [
                'client_id' => $c->id,
                'name' => trim($c->firstname . ' ' . $c->lastname),
                'registration_id' => $c->registration_id,
                'lat' => (float)$c->last_lat,
                'lng' => (float)$c->last_lng,
                'last_seen_at' => $c->last_seen_at ? $c->last_seen_at->toDateTimeString() : null,
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function stats()
{
    $totalClients = \App\Models\Client::count();

    $active24h = \App\Models\ClientLocation::where('updated_at', '>=', now()->subDay())
                    ->distinct('client_id')->count();

    $onlineNow = \App\Models\ClientLocation::where('updated_at', '>=', now()->subMinutes(5))
                    ->distinct('client_id')->count();

    // Group by Nigerian states later — for now random placeholder
    $statesCount = 23; // Replace with real state calculations later

    return response()->json([
        'total_clients' => $totalClients,
        'active_24h' => $active24h,
        'online_now' => $onlineNow,
        'states_count' => $statesCount,
    ]);
}

public function activity()
{
    // Example: activity by states or cities
    // Later you can replace with REAL client activity data

    $activity = [
        [
            'location' => 'Abuja',
            'percentage' => 35,
            'color' => '#3b82f6', // blue
        ],
        [
            'location' => 'Lagos',
            'percentage' => 25,
            'color' => '#10b981', // green
        ],
        [
            'location' => 'Port Harcourt',
            'percentage' => 20,
            'color' => '#f97316', // orange
        ],
        [
            'location' => 'Kano',
            'percentage' => 10,
            'color' => '#ef4444', // red
        ],
        [
            'location' => 'Benin',
            'percentage' => 10,
            'color' => '#a855f7', // purple
        ],
    ];

    return response()->json($activity);
}

public function heat()
{
    $clients = \App\Models\ClientLocation::select('lat','lng')->get();

    // Heatmap format: [lat, lng, intensity]
    $points = [];

    foreach ($clients as $c) {
        if ($c->lat && $c->lng) {
            $points[] = [
                floatval($c->lat),
                floatval($c->lng),
                rand(0.5, 1.2) // dynamic intensity (you can replace with real logic)
            ];
        }
    }

    return response()->json($points);
}


}
