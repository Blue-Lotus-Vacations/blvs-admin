<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentStats;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgentStatsController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->filled('month')) {
            $request->merge(['month' => now()->format('Y-m')]);
        }
        $stats = AgentStats::query()
            ->with('agent')
            ->when(
                $request->filled('agent'),
                fn($query) =>
                $query->whereHas(
                    'agent',
                    fn($qq) =>
                    $qq->where('name', 'like', '%' . $request->agent . '%')
                )
            )
            ->when(
                $request->filled('month'),
                fn($query) =>
                $query->where('month', $request->month)
            )
            ->orderByDesc('month')
            ->orderBy('agent_id')
            ->get(); // 🔁 removed ->paginate()

        return view('pages.agentStats.index', compact('stats'));
    }


    public function create()
    {
        $agents = Agent::select('id', 'name', 'image')->orderBy('name')->get();
        return view('pages.agentStats.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        AgentStats::create($data);

        return redirect()
            ->route('agent-stats.index')
            ->with('success', 'Agent stats created successfully.');
    }

    public function edit($id)
    {
        $record = AgentStats::with('agent')->findOrFail($id);
        $agents = Agent::select('id', 'name', 'image')->orderBy('name')->get();

        return view('pages.agentStats.edit', compact('record', 'agents'));
    }

    public function update(Request $request, $id)
    {
        $record = AgentStats::findOrFail($id);

        $data = $this->validateData($request, $record->id);

        $record->update($data);

        return redirect()
            ->route('agent-stats.index')
            ->with('success', 'Agent stats updated successfully.');
    }

    public function destroy($id)
    {
        $record = AgentStats::findOrFail($id);
        $record->delete();

        return redirect()
            ->route('agent-stats.index')
            ->with('success', 'Agent stats deleted.');
    }

    /**
     * Validate request and normalize "month" to YYYY-MM.
     */
    protected function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'user_id'      => ['required', 'exists:agents,id'], // from the searchable select
            'month'        => ['required', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
            'folder_count' => ['required', 'integer', 'min:0'],
            'profit'       => ['nullable', 'numeric', 'min:0'],
        ], [
            'user_id.required' => 'Please select an agent.',
        ]);

        // Map user_id -> agent_id
        $validated['agent_id'] = (int) $validated['user_id'];
        unset($validated['user_id']);

        // Enforce uniqueness of (agent_id, month)
        $uniqueRule = Rule::unique('agent_stats')->where(
            fn($q) =>
            $q->where('agent_id', $validated['agent_id'])
                ->where('month', $validated['month'])
        );
        if ($ignoreId) {
            $uniqueRule = $uniqueRule->ignore($ignoreId);
        }
        validator($validated, [
            'agent_id' => ['required'],
            'month'    => [$uniqueRule],
        ], [
            'month.unique' => 'This agent already has stats for this month.',
        ])->validate();

        return $validated;
    }

    public function inline(Request $request, $id)
    {
        $record = AgentStats::findOrFail($id);

        $data = $request->validate([
            'folder_count' => ['nullable', 'integer', 'min:0'],
            'profit'       => ['nullable', 'numeric', 'min:0'],
            'leads'        => ['nullable', 'integer', 'min:0'],
        ]);

        if (empty($data)) {
            return response()->json(['message' => 'No fields to update'], 422);
        }

        $record->fill($data);
        $record->save();

        return response()->json([
            'folder_count' => $record->folder_count,
            'profit'       => $record->profit,
            'leads'        => $record->leads,
        ]);
    }
}
