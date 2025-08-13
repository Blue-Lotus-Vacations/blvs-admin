<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Teams</h1>
            <a href="{{ route('teams.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Team</a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 border px-3 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow border rounded overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Team Name</th>
                        <th class="px-4 py-2 text-left">Members</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <td class="px-4 py-2">{{ $team->name }}</td>
                            <td class="px-4 py-2">{{ $team->agents_count }}</td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('teams.edit', $team) }}"
                                   class="text-blue-600 hover:underline mr-3">Edit</a>
                                <form method="POST" action="{{ route('teams.destroy', $team) }}" class="inline"
                                      onsubmit="return confirm('Delete this team?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
