<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IoTDevice;

class IoTController extends Controller
{
    public function index()
    {
        $devices = IoTDevice::all();
        return view('admin.iot.index', compact('devices'));
    }

    public function create()
    {
        return view('admin.iot.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_name'=>'required',
            'status'=>'required',
            'location'=>'nullable'
        ]);

        IoTDevice::create($request->all());

        return redirect()->route('admin.iot.index')->with('success','Device added successfully');
    }

    public function show(IoTDevice $iot)
    {
        return view('admin.iot.show', compact('iot'));
    }

    public function edit(IoTDevice $iot)
    {
        return view('admin.iot.edit', compact('iot'));
    }

    public function update(Request $request, IoTDevice $iot)
    {
        $request->validate([
            'device_name'=>'required',
            'status'=>'required',
            'location'=>'nullable'
        ]);

        $iot->update($request->all());
        return redirect()->route('admin.iot.index')->with('success','Device updated successfully');
    }

    public function destroy(IoTDevice $iot)
    {
        $iot->delete();
        return redirect()->route('admin.iot.index')->with('success','Device deleted successfully');
    }
}
