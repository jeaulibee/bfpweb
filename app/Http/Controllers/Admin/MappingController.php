<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapping;

class MappingController extends Controller
{
    public function index()
    {
        $mappings = Mapping::latest()->paginate(10);
        return view('admin.mapping.index', compact('mappings'));
    }

    public function create()
    {
        return view('admin.mapping.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Mapping::create($request->all());

        return redirect()->route('mapping.index')->with('success', 'Location added successfully!');
    }

    public function show(Mapping $mapping)
    {
        return view('admin.mapping.show', compact('mapping'));
    }

    public function edit(Mapping $mapping)
    {
        return view('admin.mapping.edit', compact('mapping'));
    }

    public function update(Request $request, Mapping $mapping)
    {
        $request->validate([
            'location_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $mapping->update($request->all());

        return redirect()->route('mapping.index')->with('success', 'Location updated successfully!');
    }

    public function destroy(Mapping $mapping)
    {
        $mapping->delete();
        return redirect()->route('mapping.index')->with('success', 'Location deleted successfully!');
    }
}
