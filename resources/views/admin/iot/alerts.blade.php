@extends('layouts.app')
@section('title', 'IoT Alerts')

@section('content')
<div class="card">
    <h1 class="text-xl font-semibold mb-4">IoT Alerts</h1>

    <table class="min-w-full mt-4 border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Device</th>
                <th class="border px-4 py-2">Type</th>
                <th class="border px-4 py-2">Message</th>
                <th class="border px-4 py-2">Read</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Alert::with('device')->get() as $alert)
                <tr>
                    <td class="border px-4 py-2">{{ $alert->id }}</td>
                    <td class="border px-4 py-2">{{ $alert->device->name ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($alert->type) }}</td>
                    <td class="border px-4 py-2">{{ $alert->message }}</td>
                    <td class="border px-4 py-2">{{ $alert->read ? 'Yes' : 'No' }}</td>
                    <td class="border px-4 py-2">
                        <a href="#" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
