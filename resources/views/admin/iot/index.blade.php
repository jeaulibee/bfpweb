@extends('layouts.app')
@section('title', 'IoT Devices & Alerts')

@section('content')
<div class="card">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">IoT Devices & Alerts</h2>
        <a href="{{ route('admin.iot.create') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">+ Add Device</a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-red-700 text-white">
                <th class="py-2 px-3">ID</th>
                <th class="py-2 px-3">Device Name</th>
                <th class="py-2 px-3">Status</th>
                <th class="py-2 px-3">Last Alert</th>
                <th class="py-2 px-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-3">1</td>
                <td class="py-2 px-3">ESP32 Fire Sensor</td>
                <td class="py-2 px-3">Active</td>
                <td class="py-2 px-3">2025-10-14 20:45</td>
                <td class="py-2 px-3">
                    <a href="{{ route('admin.iot.show', 1) }}" class="text-blue-600 hover:underline">View</a> |
                    <a href="{{ route('admin.iot.edit', 1) }}" class="text-green-600 hover:underline">Edit</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
