@csrf

@php 
/** @var \Illuminate\Support\Collection|\App\Models\Agent[] $agents */
$record = $record ?? null;
@endphp

<div 
    x-data="userPicker({
        users: @js($agents->map(fn($u) => ['id' => $u->id, 'name' => $u->name, 'email' => $u->email ?? null])),
        preselectedId: {{ old('user_id', $record->agent_id ?? 'null') ? (int) old('user_id', $record->agent_id ?? null) : 'null' }},
    })"
    class="space-y-6"
>
    {{-- Agent (searchable single-select) --}}
    <div class="relative">
        <label class="block text-sm font-medium mb-1">Agent <span class="text-red-500">*</span></label>

        <input type="hidden" name="user_id" x-model="selected?.id">

        <div class="relative">
            <input
                type="text"
                x-model="query"
                @focus="open = true"
                @keydown.escape="open = false"
                @click.away="open = false"
                :placeholder="selected ? selected.name + (selected.email ? (' ('+selected.email+')') : '') : 'Search agent by name or email...'"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
                :class="{'pr-9': selected}"
            >
            <button
                type="button"
                x-show="selected"
                @click="clearSelection()"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                aria-label="Clear selected agent"
            >&times;</button>
        </div>

        <div x-cloak x-show="open"
             class="absolute z-10 mt-1 w-full max-h-64 overflow-auto bg-white border rounded shadow">
            <template x-for="u in filtered" :key="u.id">
                <button type="button" @click="select(u)" class="w-full text-left px-3 py-2 hover:bg-gray-50">
                    <div class="font-medium" x-text="u.name"></div>
                    <div class="text-xs text-gray-500" x-text="u.email"></div>
                </button>
            </template>
            <div x-show="filtered.length === 0" class="px-3 py-2 text-sm text-gray-500">No agents found.</div>
        </div>

        @error('user_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Month (Year + Month) --}}
    <div>
        <label class="block text-sm font-medium mb-1">Month <span class="text-red-500">*</span></label>
        <input
            type="month"
            name="month"
            value="{{ old('month', isset($record->month) ? substr($record->month, 0, 7) : '') }}"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
            required
        >
        @error('month')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-xs text-gray-500">Format: YYYY-MM</p>
    </div>

    {{-- Folder Count --}}
    <div>
        <label class="block text-sm font-medium mb-1">Folder Count <span class="text-red-500">*</span></label>
        <input
            type="number"
            name="folder_count"
            min="0"
            step="1"
            value="{{ old('folder_count', $record->folder_count ?? '') }}"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
            required
        >
        @error('folder_count')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Profit --}}
    <div>
        <label class="block text-sm font-medium mb-1">Profit</label>
        <input
            type="number"
            name="profit"
            min="0"
            step="0.01"
            value="{{ old('profit', $record->profit ?? '') }}"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-500"
            placeholder="e.g., 145000.00"
        >
        @error('profit')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-xs text-gray-500">Optional. Base currency.</p>
    </div>

    <div class="pt-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save
        </button>
    </div>
</div>

<script>
    function userPicker({ users, preselectedId = null }) {
        const selectedInit = preselectedId ? users.find(u => u.id === preselectedId) || null : null;
        return {
            open: false,
            users,
            query: '',
            selected: selectedInit,
            get filtered() {
                const q = this.query.toLowerCase().trim();
                if (!q) return this.users.slice(0, 50);
                return this.users.filter(u =>
                    (u.name || '').toLowerCase().includes(q) ||
                    (u.email || '').toLowerCase().includes(q)
                ).slice(0, 50);
            },
            select(u) { this.selected = u; this.query=''; this.open=false; },
            clearSelection() { this.selected=null; this.query=''; this.open=false; }
        }
    }
</script>
