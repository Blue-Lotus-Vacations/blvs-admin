<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Edit Agent Stats</h1>

        <form action="{{ route('agent-stats.update', $record->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            @include('pages.agentStats._form', ['agents' => $agents, 'record' => $record])
        </form>
    </div>
</x-app-layout>
