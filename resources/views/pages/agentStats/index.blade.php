<x-app-layout>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold">Agent Stats</h1>
            <a href="{{ route('agent-stats.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Add
            </a>
        </div>

        @if(session('success'))
        <div class="mb-4 text-green-700 bg-green-100 border border-green-200 px-3 py-2 rounded">
            {{ session('success') }}
        </div>
        @endif

        {{-- Filters --}}
        <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-3">
            <input type="text" name="agent" value="{{ request('agent') }}"
                placeholder="Search by agent name"
                class="border rounded px-3 py-2 w-full">
            <input type="month" name="month" value="{{ request('month') }}"
                class="border rounded px-3 py-2 w-full">
            <button class="bg-gray-800 text-white rounded px-4 py-2 w-full md:w-auto">Filter</button>
        </form>

        <div class="overflow-x-auto bg-white border rounded">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-2 border-b">Agent</th>
                        <th class="text-left px-4 py-2 border-b">Month</th>
                        <th class="text-right px-4 py-2 border-b">Leads</th>
                        <th class="text-right px-4 py-2 border-b">Folder Count</th>
                        <th class="text-right px-4 py-2 border-b">Profit</th>
                        <th class="text-right px-4 py-2 border-b">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($stats as $row)
                    <tr class="odd:bg-white even:bg-gray-50"
                        x-data="inlineRow({
        id: {{ $row->id }},
        leadsInit: {{ (int) $row->leads }},
        folderInit: {{ (int) $row->folder_count }},
        profitInit: {{ $row->profit !== null ? (float) $row->profit : 'null' }},
        url: '{{ route('agent-stats.inline', $row->id) }}',
        token: '{{ csrf_token() }}',
    })">
                        <td class="px-4 py-2 border-b">{{ $row->agent?->name ?? '—' }}</td>
                        <td class="px-4 py-2 border-b">{{ $row->month }}</td>
                        {{-- Leads (editable) --}}
                        <td class="px-4 py-2 border-b text-right">
                            <input type="number" min="0" step="1"
                                x-model.number="leads"
                                @blur="save({ leads: leads })"
                                @keydown.enter.prevent="$event.target.blur()"
                                class="w-24 text-right border rounded px-2 py-1 focus:outline-none focus:ring focus:border-blue-500">
                            <div class="text-xs mt-1" x-show="status3" x-text="status3"></div>
                        </td>

                        {{-- Folder Count (editable) --}}
                        <td class="px-4 py-2 border-b text-right">
                            <input type="number" min="0" step="1"
                                x-model.number="folder"
                                @blur="save({ folder_count: folder })"
                                @keydown.enter.prevent="$event.target.blur()"
                                class="w-28 text-right border rounded px-2 py-1 focus:outline-none focus:ring focus:border-blue-500">
                            <div class="text-xs mt-1" x-show="status" x-text="status"></div>
                        </td>

                       



                        {{-- Profit (editable) --}}
                        <td class="px-4 py-2 border-b text-right">
                            <input type="number" min="0" step="0.01"
                                x-model.number="profit"
                                @blur="save({ profit: profit })"
                                @keydown.enter.prevent="$event.target.blur()"
                                class="w-32 text-right border rounded px-2 py-1 focus:outline-none focus:ring focus:border-blue-500">
                            <div class="text-xs mt-1" x-show="status2" x-text="status2"></div>
                        </td>

                        <td class="px-4 py-2 border-b text-right">
                            <a href="{{ route('agent-stats.edit', $row->id) }}"
                                class="text-blue-600 hover:underline mr-3">Edit</a>
                            <form action="{{ route('agent-stats.destroy', $row->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this record?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">No records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- Alpine helper --}}
    <script>
    function inlineRow({ id, leadsInit, folderInit, profitInit, url, token }) {
        return {
            leads: leadsInit,
            folder: folderInit,
            profit: profitInit,
            status: '',
            status2: '',
            status3: '',

            async save(payload) {
                const key = Object.keys(payload)[0];
                const statusMap = {
                    'folder_count': 'status',
                    'profit': 'status2',
                    'leads': 'status3',
                };
                const statusKey = statusMap[key] || 'status';

                this[statusKey] = 'Saving…';

                try {
                    const res = await fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });

                    if (!res.ok) {
                        const err = await res.json().catch(() => ({}));
                        throw new Error(err.message || 'Failed');
                    }

                    const data = await res.json();
                    if (data.folder_count !== undefined) this.folder = data.folder_count;
                    if (data.profit !== undefined) this.profit = data.profit;
                    if (data.leads !== undefined) this.leads = data.leads;

                    this[statusKey] = 'Saved';
                    setTimeout(() => this[statusKey] = '', 1200);
                } catch (e) {
                    this[statusKey] = 'Error';
                    console.error(e);
                }
            }
        }
    }
</script>

</x-app-layout>