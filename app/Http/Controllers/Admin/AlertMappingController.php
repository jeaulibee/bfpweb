<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlertMapping;
use App\Models\Alert;
use Illuminate\Support\Facades\Log;

class AlertMappingController extends Controller
{
    public function index()
    {
        // Load all alerts that have coordinates
        $mappings = AlertMapping::with('alert.device')->latest()->get();

        return view('admin.mapping.index', compact('mappings'));
    }

    // Optional API endpoint for AJAX map loading
    public function getAlertMappings()
    {
        $mappings = AlertMapping::with(['alert.device'])->latest()->get();
        return response()->json($mappings);
    }
}
