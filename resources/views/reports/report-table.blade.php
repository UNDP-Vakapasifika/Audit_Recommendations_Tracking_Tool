@props(['recommendations'])

<div class="shadow-lg rounded overflow-x-auto">
    <table class="w-full whitespace-nowrap">
        <thead>
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Report Numbers</th>
                <th class="px-4 py-2">Report Title</th>
                <th class="px-4 py-2">Recommendation</th>
                <th class="px-4 py-2">Implementation Status</th>
                <!-- Add more table headers as needed -->
            </tr>
        </thead>
        <tbody>
            @forelse ($recommendations as $recommendation)
                <tr>
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $recommendation->report_numbers }}</td>
                    <td class="px-4 py-2">{{ $recommendation->report_title }}</td>
                    <td class="px-4 py-2">{{ $recommendation->recommendation }}</td>
                    <td class="px-4 py-2">{{ $recommendation->implementation_status }}</td>
                    <!-- Add more table cells as needed -->
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No recommendations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


