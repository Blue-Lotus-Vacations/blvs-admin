<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">
            {{ isset($topRanker) ? 'Edit Ranker' : 'Add Ranker' }}
        </h2>
        <form method="POST" enctype="multipart/form-data"
              action="{{ isset($topRanker) ? route('top-rankers.update', $topRanker) : route('top-rankers.store') }}">
            @csrf
            @if(isset($topRanker)) @method('PUT') @endif
            @include('pages.top_rankers.form')
        </form>
    </div>
</x-app-layout>
