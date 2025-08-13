<x-app-layout>
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-xl font-semibold mb-4">{{ isset($team) ? 'Edit Team' : 'Create Team' }}</h1>

        <form method="POST" action="{{ isset($team) ? route('teams.update', $team) : route('teams.store') }}">
            @csrf
            @if(isset($team)) @method('PUT') @endif

            <div class="mb-4">
                <label class="block font-medium text-sm mb-1">Team Name</label>
                <input type="text" name="name" value="{{ old('name', $team->name ?? '') }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm mb-1">Assign Agents</label>
                <select name="agents[]" multiple
                        class="w-full border rounded px-3 py-2 h-40">
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}"
                            {{ isset($team) && $agent->team_id == $team->id ? 'selected' : '' }}>
                            {{ $agent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
