<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Add Agent Stats</h1>

        <form action="{{ route('agent-stats.store') }}" method="POST" class="space-y-6">
            @include('pages.agentStats._form', ['agents' => $agents, 'record' => null])
        </form>
    </div>
</x-app-layout>
