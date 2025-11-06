<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;

class AlertController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $alerts = Alert::with('device')->orderBy('created_at', 'desc')->get();
        return view('staff.alerts.index', compact('alerts'));
    }

    public function show(Alert $alert)
    {
        return view('staff.alerts.show', compact('alert'));
    }

    // Mark alert as read
    public function markRead(Alert $alert)
    {
        $alert->update(['read' => true]);
        return redirect()->back()->with('success', 'Alert marked as read.');
    }
}
