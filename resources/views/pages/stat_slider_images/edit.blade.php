<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Edit Image</h2>
        <form method="POST" action="{{ route('stat-slider-images.update', $statSliderImage) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('pages.stat_slider_images.form', ['statSliderImage' => $statSliderImage])
        </form>
    </div>
</x-app-layout>
