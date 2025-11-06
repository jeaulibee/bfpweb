@extends('layouts.app')
@section('title', 'IoT Device Details')

@section('content')
<div class="card">
    <h2 class="text-lg font-semibold mb-4">Device #1 Details</h2>

    <p><strong>Device Name:</strong> ESP32 Fire Sensor</p>
    <p><strong>Type:</strong> Fire Sensor</p>
    <p><strong>Status:</strong> Active</p>
    <p><strong>Last Alert:</strong> 2025-10-14 20:45</p>

    <a href="{{ route('admin.iot.index') }}" class="mt-4 inline-block bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Back</a>
</div>
@endsection
