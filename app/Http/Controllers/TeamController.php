<?php
namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\Agent;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::withCount('agents')->get();
        return view('pages.teams.index', compact('teams'));
    }

    public function create()
    {
        $agents = Agent::whereNull('team_id')->get();
        return view('pages.teams.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'agents' => ['nullable', 'array'],
            'agents.*' => ['exists:agents,id'],
        ]);

        $team = Team::create(['name' => $data['name']]);

        if (!empty($data['agents'])) {
            Agent::whereIn('id', $data['agents'])->update(['team_id' => $team->id]);
        }

        return redirect()->route('teams.index')->with('success', 'Team created.');
    }

    public function edit(Team $team)
    {
        $agents = Agent::all();
        return view('pages.teams.edit', compact('team', 'agents'));
    }

    public function update(Request $request, Team $team)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'agents' => ['nullable', 'array'],
            'agents.*' => ['exists:agents,id'],
        ]);

        $team->update(['name' => $data['name']]);

        // Remove old assignments
        Agent::where('team_id', $team->id)->update(['team_id' => null]);

        // Assign new
        if (!empty($data['agents'])) {
            Agent::whereIn('id', $data['agents'])->update(['team_id' => $team->id]);
        }

        return redirect()->route('teams.index')->with('success', 'Team updated.');
    }

    public function destroy(Team $team)
    {
        Agent::where('team_id', $team->id)->update(['team_id' => null]);
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team deleted.');
    }
}
