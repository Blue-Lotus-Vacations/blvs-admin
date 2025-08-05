<?php
namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::all();
        return view('pages.agents.index', compact('agents'));
    }

    public function create()
    {
        return view('pages.agents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable',
        ]);

        $data['name'] = $request->input(['name']);
        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('agents', 'public');
        }
        Agent::create($data);

        return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
    }

    public function edit(Agent $agent)
    {
        return view('pages.agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable',
        ]);

        $data['name'] = $request->input(['name']);
        if ($request->hasFile('image')) {
            if ($agent->image && file_exists(public_path($agent->image))) {
                unlink(public_path($agent->image));
            }
            $data['image'] = '/storage/' . $request->file('image')->store('agents', 'public');
        }

        $agent->update($data);

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
    }
}
