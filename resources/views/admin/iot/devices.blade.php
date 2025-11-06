@extends('layouts.app')
@section('title', 'IoT Devices')

@section('content')
<div class="card">
    <h1 class="text-xl font-semibold mb-4">IoT Devices</h1>

    <a href="{{ route('admin.iot.devices.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Add New Device</a>

    <table class="min-w-full mt-4 border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Serial Number</th>
                <th class="border px-4 py-2">Location</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Device::all() as $device)
                <tr>
                    <td class="border px-4 py-2">{{ $device->id }}</td>
                    <td class="border px-4 py-2">{{ $device->name }}</td>
                    <td class="border px-4 py-2">{{ $device->serial_number }}</td>
                    <td class="border px-4 py-2">{{ $device->location }}</td>
                    <td class="border px-4 py-2">
                        <a href="#" class="text-blue-600 hover:underline">Edit</a> |
                        <a href="#" class="text-red-600 hover:underline">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
