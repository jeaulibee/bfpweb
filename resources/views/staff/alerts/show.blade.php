@extends('layouts.app')
@section('title', 'View Alert')

@section('content')
<div class="card">
    <h1 class="text-xl font-semibold mb-4">Alert Details</h1>

    <div class="mb-4">
        <strong>Device:</strong> {{ $alert->device->name ?? 'N/A' }}
    </div>
    <div class="mb-4">
        <strong>Type:</strong> {{ ucfirst($alert->type) }}
    </div>
    <div class="mb-4">
        <strong>Message:</strong> {{ $alert->message }}
    </div>
    <div class="mb-4">
        <strong>Read:</strong> {{ $alert->read ? 'Yes' : 'No' }}
    </div>

    <a href="{{ route('admin.alerts.index') }}" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 transition">Back</a>
</div>
@endsection
