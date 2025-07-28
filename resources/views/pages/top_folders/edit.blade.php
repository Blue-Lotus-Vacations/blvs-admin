<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-6">Edit Top Folder</h1>

        <form action="{{ route('top-folders.update', $topFolder) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            @include('pages.top_folders._form')
        </form>
    </div>
</x-app-layout>
