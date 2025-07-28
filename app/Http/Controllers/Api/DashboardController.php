<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Agent;
use App\Models\Quote;
use App\Models\StatSliderImage;
use Illuminate\Support\Facades\URL;

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
        $quotes = Quote::select('id', 'text', 'backgroundImage')->get()->map(function ($quote) {
            return [
                'id' => $quote->id,
                'text' => $quote->text,
                'backgroundImage' => $quote->backgroundImage 
                    ? URL::to($quote->backgroundImage)
                    : null,
            ];
        });
    
        return response()->json([
            'quotes' => $quotes
        ], 200, [
            'Access-Control-Allow-Origin' => '*',
        ]);
    }

    public function statSliderImages()
    {
        $images = StatSliderImage::select('id', 'url', 'alt', 'overlay_text as overlayText')->get();

        return response()->json([
            'images' => $images
        ], 200, [
            'Access-Control-Allow-Origin' => '*',
        ]);
    }
}
