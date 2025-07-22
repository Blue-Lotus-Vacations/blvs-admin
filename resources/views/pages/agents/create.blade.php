<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Add New Agent</h2>
        <form method="POST" action="{{ route('agents.store') }}">
            @include('pages.agents.form')
        </form>
    </div>
</x-app-layout>
