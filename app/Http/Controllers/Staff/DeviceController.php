<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $devices = Device::all(); // Staff can view all devices
        return view('staff.devices.index', compact('devices'));
    }

    public function show(Device $device)
    {
        return view('staff.devices.show', compact('device'));
    }
}
