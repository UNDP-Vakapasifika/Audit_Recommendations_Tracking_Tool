<div>
    <table class="w-full border border-gray-200">
        <thead>
            <tr>
                <th class="border border-gray-200 px-4 py-2">Action Type</th>
                <th class="border border-gray-200 px-4 py-2">Description</th>
                <th class="border border-gray-200 px-4 py-2">IP Address</th>
                <th class="border border-gray-200 px-4 py-2">Date Created</th>
                <th class="border border-gray-200 px-4 py-2">Date Updated</th>
            </tr>
        </thead>

        <tbody>
            @foreach($logs as $log)
                <tr>
                    @if(is_array($log->activity))
                        <td class="border border-gray-200 px-4 py-2">{{ $log->activity['type'] }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $log->activity['description'] }}</td>
                    @else
                        <td class="border border-gray-200 px-4 py-2">{{ $log->action}}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $log->activity}}</td>
                    @endif
                    <td class="border border-gray-200 px-4 py-2">{{ $log->ip_address }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $log->updated_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Display pagination links -->
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
