@extends('layouts.app')
@section('title', 'Add IoT Device')

@section('content')
<div class="card">
    <h2 class="text-lg font-semibold mb-4">Add New IoT Device</h2>

    <form>
        <div class="mb-3">
            <label class="block mb-2 font-medium">Device Name</label>
            <input type="text" class="border w-full p-2 rounded" placeholder="Enter device name">
        </div>

        <div class="mb-3">
            <label class="block mb-2 font-medium">Type</label>
            <select class="border w-full p-2 rounded">
                <option>Fire Sensor</option>
                <option>Smoke Detector</option>
                <option>Gas Sensor</option>
            </select>
        </div>

        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Submit</button>
    </form>
</div>
@endsection
