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
        // Define date range: from Jan 1st this year to last full month
        $startMonth = Carbon::now()->startOfYear()->format('Y-m');       // e.g. 2025-01
        $lastMonth  = Carbon::now()->subMonth()->format('Y-m');          // e.g. 2025-07

        $startLabel = Carbon::createFromFormat('Y-m', $startMonth)->format('M');
        $endLabel   = Carbon::createFromFormat('Y-m', $lastMonth)->format('F');

        // Aggregate total folder counts (and profit for tie-breaking) across the date range
        $rows = AgentStats::query()
            ->whereBetween('month', [$startMonth, $lastMonth])
            ->join('agents', 'agents.id', '=', 'agent_stats.agent_id')
            ->groupBy('agents.id', 'agents.name', 'agents.image')
            ->select([
                'agents.name as agent',
                'agents.image as image',
                DB::raw('SUM(agent_stats.folder_count) as total_folders'),
                DB::raw('SUM(agent_stats.profit) as total_profit'),
            ])
            ->orderByDesc('total_folders')
            ->orderByDesc('total_profit')
            ->orderBy('agents.name')
            ->limit(5)
            ->get();

        $agents = $rows->values()->map(function ($r, $i) {
            return [
                'agent'       => $r->agent,
                'folderCount' => (int) $r->total_folders,
                'globalRank'  => $i + 1,
                'image'       => $r->image ? url($r->image) : null,
            ];
        });

        return response()->json([
            'title'    => "{$startLabel} to {$endLabel} Folder Conversions",
            'subtitle' => "Most Active Agents from {$startLabel} to {$endLabel}",
            'agents'   => $agents,
        ]);
    }

    public function topProfitLeaders()
    {
        // Range: January (current year) to last month (YYYY-MM)
        $lastMonth = Carbon::now()->subMonth();
        $startMonth = Carbon::now()->startOfYear(); // Jan 1 of current year

        $start = $startMonth->format('Y-m');     // e.g. 2025-01
        $end   = $lastMonth->format('Y-m');      // e.g. 2025-07

        $startLabel = $startMonth->format('M');            // Jan 2025
        $endLabel   = $lastMonth->format('M');

        // Aggregate totals per agent within the range
        $rows = AgentStats::query()
            ->join('agents', 'agents.id', '=', 'agent_stats.agent_id')
            ->whereBetween('agent_stats.month', [$start, $end]) // months stored as 'YYYY-MM'
            ->groupBy('agents.id', 'agents.name', 'agents.image')
            ->select([
                'agents.name as agent',
                'agents.image as image',
                DB::raw('COALESCE(SUM(agent_stats.profit), 0) as total_profit'),
                DB::raw('COALESCE(SUM(agent_stats.folder_count), 0) as total_folders'),
            ])
            ->orderByDesc('total_profit')
            ->orderBy('agents.name')
            ->limit(5)
            ->get();

        // Build payload with rank and image URL
        $agents = $rows->values()->map(function ($r, $i) {
            return [
                'agent'       => $r->agent,
                'profit'      => (float) $r->total_profit,
                'folderCount' => (int) $r->total_folders,
                'image'       => $r->image ? url($r->image) : null, // adjust if you store relative paths
                'rank'        => $i + 1,
            ];
        });

        return response()->json([
            'title'    => "{$startLabel} to {$endLabel} Top 5 Profit Leaders",
            'subtitle' => 'Top performing agents by total profit',
            'agents'   => $agents,
        ]);
    }
}
