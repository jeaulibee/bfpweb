@extends('layouts.app')
@section('title', 'Edit IoT Device')

@section('content')
<div class="card">
    <h2 class="text-lg font-semibold mb-4">Edit Device #1</h2>

    <form>
        <div class="mb-3">
            <label class="block mb-2 font-medium">Device Name</label>
            <input type="text" value="ESP32 Fire Sensor" class="border w-full p-2 rounded">
        </div>

        <div class="mb-3">
            <label class="block mb-2 font-medium">Type</label>
            <select class="border w-full p-2 rounded">
                <option selected>Fire Sensor</option>
                <option>Smoke Detector</option>
                <option>Gas Sensor</option>
            </select>
        </div>

        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Update</button>
    </form>
</div>
@endsection
