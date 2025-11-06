@extends('layouts.app')
@section('title', 'Add Mapping Location')

@section('content')
<div class="card">
    <h2 class="text-lg font-semibold mb-4">Add New Location</h2>

    <form>
        <div class="mb-3">
            <label class="block mb-2 font-medium">Location Name</label>
            <input type="text" class="border w-full p-2 rounded" placeholder="Enter location name">
        </div>

        <div class="mb-3">
            <label class="block mb-2 font-medium">Coordinates</label>
            <input type="text" class="border w-full p-2 rounded" placeholder="Enter GPS coordinates">
        </div>

        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Submit</button>
    </form>
</div>
@endsection
