@extends('layouts.app')
@section('title', 'Mapping Details')

@section('content')
<div class="card">
    <h2 class="text-lg font-semibold mb-4">Location #1 Details</h2>

    <p><strong>Location:</strong> Koronadal City</p>
    <p><strong>Coordinates:</strong> 6.4939° N, 124.8481° E</p>

    <a href="{{ route('admin.mapping.index') }}" class="mt-4 inline-block bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Back</a>
</div>
@endsection
