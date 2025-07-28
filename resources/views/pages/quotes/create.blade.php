<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Add New Quote</h2>
        <form action="{{ route('quotes.store') }}" method="POST" enctype="multipart/form-data">
            @include('pages.quotes.form')
        </form>
    </div>
</x-app-layout>
