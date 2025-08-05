<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Agent;
use App\Models\AgentStats;
use App\Models\Quote;
use App\Models\StatSliderImage;
use App\Models\TopRanker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class DashboardController extends Controller
{
    public function agentStats()
    {
        $latestFolder = AgentStats::select('folder_count')
            ->whereColumn('agent_id', 'agents.id')
            ->orderByDesc('month')
            ->limit(1);

        $latestProfit = AgentStats::select('profit')
            ->whereColumn('agent_id', 'agents.id')
            ->orderByDesc('month')
            ->limit(1);



        $agents = Agent::query()
            ->select('agents.name as agent')
            ->selectSub($latestFolder, 'folder_count')
            ->selectSub($latestProfit, 'profit')
            // order by latest profit desc:
            ->orderByDesc($latestProfit)
            ->get()
            ->map(function ($agent) {
                return [
                    'agent'       => $agent->agent,
                    'folderCount' => (int) ($agent->folder_count ?? 0),
                    'profit'      => (float) ($agent->profit ?? 0),
                    'trend'       => $agent->trend ?? 'stable',
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
        // Get last month in YYYY-MM format
        $month = Carbon::now()->subMonth()->format('Y-m');

        // Fetch top 5 agents for that month
        $rows = AgentStats::query()
            ->where('agent_stats.month', $month)
            ->join('agents', 'agents.id', '=', 'agent_stats.agent_id')
            ->select([
                'agents.name as agent',
                'agents.image as image',
                'agent_stats.folder_count',
                'agent_stats.profit',
            ])
            ->orderByDesc('agent_stats.profit')
            ->orderByDesc('agent_stats.folder_count')
            ->limit(5)
            ->get();

        // Build final response structure
        $top = $rows->values()->map(function ($r, $i) {
            return [
                'agent'       => $r->agent,
                'folderCount' => (int) $r->folder_count,
                'profit'      => (float) ($r->profit ?? 0),
                'globalRank'  => $i + 1,
                'image'       => $r->image ? url($r->image) : null,
            ];
        });

        $monthName = Carbon::createFromFormat('Y-m', $month)->format('F');

        return response()->json([
            'title'    => "{$monthName} Top Performers",
            'subtitle' => "Outstanding Results for {$monthName} Month",
            'agents'   => $top,
        ]);
    }

    public function topFolders()
    {
        // Always last month (YYYY-MM)
        $month = Carbon::now()->subMonth()->format('Y-m');
        $monthName = Carbon::createFromFormat('Y-m', $month)->format('F');

        // Top 5 by folder_count (tie-breaker: profit desc, then agent name)
        $rows = AgentStats::query()
            ->where('agent_stats.month', $month)
            ->join('agents', 'agents.id', '=', 'agent_stats.agent_id')
            ->select([
                'agents.name as agent',
                'agents.image as image',
                'agent_stats.folder_count',
                DB::raw('COALESCE(agent_stats.profit, 0) as profit'),
            ])
            ->orderByDesc('agent_stats.folder_count')
            ->orderByDesc('agent_stats.profit')
            ->orderBy('agents.name')
            ->limit(5)
            ->get();

        $agents = $rows->values()->map(function ($r, $i) {
            return [
                'agent'       => $r->agent,
                'folderCount' => (int) $r->folder_count,
                'globalRank'  => $i + 1,
                // if you store relative paths in agents.image (e.g. "avatars/a.jpg")
                // this matches your original asset('storage/...') style:
                'image'       => $r->image ? asset('storage/' . ltrim($r->image, '/')) : null,
            ];
        });

        return response()->json([
            'title'    => " {$monthName} Top Folders",
            'subtitle' => "Most Active Agents for Month {$monthName}",
            'agents'   => $agents,
        ]);
    }
    
    public function totalProfit()
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
}
