<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Agent;
use App\Models\Quote;
use App\Models\StatSliderImage;
use App\Models\TopRanker;
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
                'textColor' => $quote->textColor ?? '#ffffff',
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

    public function topRankers()
    {
        $top = TopRanker::orderBy('global_rank')->limit(5)->get()->map(function ($r) {
            return [
                'agent' => $r->agent,
                'folderCount' => $r->folder_count,
                'profit' => $r->profit,
                'trend' => $r->trend,
                'globalRank' => $r->global_rank,
                'image' => $r->image ? url($r->image) : null,
            ];
        });

        return response()->json([
            'title' => ' June Top Performers',
            'subtitle' => 'Outstanding Results for June Month', // You can change this manually
            'agents' => $top
        ]);
    }

    public function topFolders()
    {
        return response()->json([
            'title' => ' June Top Folders',
            'subtitle' => 'Most Active Agents for Month June',
            'agents' => \App\Models\TopFolder::orderBy('global_rank')->limit(5)->get()->map(function ($r) {
                return [
                    'agent' => $r->agent,
                    'folderCount' => $r->folder_count,
                    'trend' => $r->trend,
                    'globalRank' => $r->global_rank,
                    'image' => $r->image ? asset('storage/' . $r->image) : null,
                ];
            }),
        ]);
    }
}
