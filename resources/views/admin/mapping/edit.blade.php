@extends('layouts.app')
@section('title', 'Edit Mapping Location')

@section('content')
<div class="card">
    <h2 class="text-lg font-semibold mb-4">Edit Location #1</h2>

    <form>
        <div class="mb-3">
            <label class="block mb-2 font-medium">Location Name</label>
            <input type="text" value="Koronadal City" class="border w-full p-2 rounded">
        </div>

        <div class="mb-3">
            <label class="block mb-2 font-medium">Coordinates</label>
            <input type="text" value="6.4939° N, 124.8481° E" class="border w-full p-2 rounded">
        </div>

        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Update</button>
    </form>
</div>
@endsection
