<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    // List all citizens
    public function index()
    {
        $citizens = Citizen::all();
        return response()->json($citizens);
    }

    // Store a new citizen
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'nullable|email|unique:citizens,email',
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
        ]);

        $citizen = Citizen::create($request->all());

        return response()->json([
            'message' => 'Citizen created successfully',
            'citizen' => $citizen
        ]);
    }

    // Show a single citizen
    public function show($id)
    {
        $citizen = Citizen::findOrFail($id);
        return response()->json($citizen);
    }

    // Update a citizen
    public function update(Request $request, $id)
    {
        $citizen = Citizen::findOrFail($id);

        $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name'  => 'sometimes|required|string|max:255',
            'email'      => 'nullable|email|unique:citizens,email,' . $citizen->id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
        ]);

        $citizen->update($request->all());

        return response()->json([
            'message' => 'Citizen updated successfully',
            'citizen' => $citizen
        ]);
    }

    // Delete a citizen
    public function destroy($id)
    {
        $citizen = Citizen::findOrFail($id);
        $citizen->delete();

        return response()->json([
            'message' => 'Citizen deleted successfully'
        ]);
    }
}
