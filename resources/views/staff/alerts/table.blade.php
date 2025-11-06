<table class="min-w-full border-collapse border border-gray-200">
    <thead>
        <tr class="bg-gray-100">
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Type</th>
            <th class="border px-4 py-2">Message</th>
            <th class="border px-4 py-2">Time</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($alerts as $alert)
            <tr class="hover:bg-gray-50">
                <td class="border px-4 py-2">{{ $alert->id }}</td>
                <td class="border px-4 py-2 font-semibold">{{ ucfirst($alert->type) }}</td>
                <td class="border px-4 py-2">{{ $alert->message }}</td>
                <td class="border px-4 py-2 text-gray-600">{{ $alert->created_at->format('Y-m-d H:i:s') }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('admin.alerts.show', $alert->id) }}" class="text-blue-600 hover:underline">View</a>
                    <form action="{{ route('admin.alerts.destroy', $alert->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete this alert?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="border px-4 py-2 text-center text-gray-500">No alerts found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
