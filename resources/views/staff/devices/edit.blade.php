@extends('layouts.app')
@section('title', 'Edit Device')

@section('content')
<div class="card">
    <h1 class="text-xl font-semibold mb-4">Edit Device</h1>

    <form action="{{ route('admin.devices.update', $device->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Device Name</label>
            <input type="text" name="name" value="{{ $device->name }}" class="w-full border rounded-md px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Serial Number</label>
            <input type="text" name="serial_number" value="{{ $device->serial_number }}" class="w-full border rounded-md px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Location</label>
            <input type="text" name="location" value="{{ $device->location }}" class="w-full border rounded-md px-3 py-2">
        </div>
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Update</button>
    </form>
</div>
@endsection
