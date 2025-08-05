<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Edit Agent</h2>
        <form method="POST" action="{{ route('agents.update', $agent) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('pages.agents.form', ['agent' => $agent])
        </form>
    </div>
</x-app-layout>
