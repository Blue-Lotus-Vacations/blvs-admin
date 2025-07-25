<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Add New Stat Slider Image</h2>
        <form method="POST" action="{{ route('stat-slider-images.store') }}" enctype="multipart/form-data">
            @include('pages.stat_slider_images.form')
        </form>
    </div>
</x-app-layout>
