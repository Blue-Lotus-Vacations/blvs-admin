<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Edit Quote</h2>
        <form action="{{ route('quotes.update', $quote) }}" method="POST">
            @csrf @method('PUT')
            @include('pages.quotes.form', ['quote' => $quote])
        </form>
    </div>
</x-app-layout>
