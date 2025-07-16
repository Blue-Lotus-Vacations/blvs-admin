<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight mb-4">Call Logs</h2>

        <div class="flex items-center mb-2">
            <div class="bg-red-200 h-4 w-4 mr-2">

            </div>
            <span> - Missed Calls</span>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow ring-1 ring-black ring-opacity-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">From</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">To</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Start</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">End</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Duration</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Missed Extensions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white text-sm text-gray-700">
                    @forelse ($logs as $log)
                    <tr @class([ 'px-4 py-2' , 'bg-red-50'=> !empty($log->missed_queue_calls)])>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->from_no }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->to_no }} - {{ $log->final_dispname }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->time_start }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->time_end }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->reason_terminated ?? '-' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->duration ?? '-' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if (!empty($log->missed_queue_calls))
                            <ul class="list-disc list-inside space-y-1 text-gray-700">
                                @foreach (explode(';', $log->missed_queue_calls) as $ext)
                                @if (!empty(trim($ext)))
                                <li>{{ trim($ext) }}</li>
                                @endif
                                @endforeach
                            </ul>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No call logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>