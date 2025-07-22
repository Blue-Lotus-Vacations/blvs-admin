<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Agent;
use App\Models\Quote;

class DashboardController extends Controller
{
    public function agents()
    {
        $agents = Agent::select('name as agent', 'folder_count', 'profit', 'trend')
            ->orderByDesc('profit')
            ->get()
            ->map(function ($agent) {
                return [
                    'agent' => $agent->agent,
                    'folderCount' => (int) $agent->folder_count,
                    'profit' => (int) $agent->profit,
                    'trend' => $agent->trend ?? 'stable',
                ];
            });

        return response()->json(['agents' => $agents], 200, [
            'Access-Control-Allow-Origin' => '*',
        ]);
    }

    public function quotes()
    {
        $quotes = Quote::pluck('text');

        return response()->json(['quotes' => $quotes], 200, [
            'Access-Control-Allow-Origin' => '*',
        ]);
    }
}