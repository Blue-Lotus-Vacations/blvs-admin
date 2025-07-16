<x-app-layout>

    <h2 class="text-xl font-semibold text-gray-800 leading-tight">📞 Call Logs</h2>


    <div class="py-6 px-4">


        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">From</th>
                        <th class="px-4 py-2">To</th>
                        <th class="px-4 py-2">Start</th>
                        <th class="px-4 py-2">End</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Duration</th>
                        <th class="px-4 py-2">Missed Extensions</th>


                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $log->from_no }}</td>
                        <td class="px-4 py-2">{{ $log->to_no }} - {{ $log->to_dispname }}</td>
                        <td class="px-4 py-2">{{ $log->time_start }}</td>
                        <td class="px-4 py-2">{{ $log->time_end }}</td>
                        <td class="px-4 py-2">{{ $log->reason_terminated ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $log->duration ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if (!empty($log->missed_queue_calls))
                            <ul class="list-disc pl-5">
                                @foreach (explode(';', $log->missed_queue_calls) as $ext)
                                @if (!empty($ext))
                                <li>{{ $ext }}</li>
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
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No call logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>