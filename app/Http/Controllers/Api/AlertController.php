<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;

class AlertController extends Controller
{
    public function store(Request $request)
    {
        try {
            $alert = Alert::create([
                'type' => $request->type,
                'message' => $request->message,
                'device_id' => $request->device_id ?? null,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'data' => $alert
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
