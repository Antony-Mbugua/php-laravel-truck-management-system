<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceType;

class MaintenanceTypeController extends Controller
{
    // Display a list of maintenance types
    public function index()
    {
        $maintenanceTypes = MaintenanceType::all();
        return view('maintenance_types.index', compact('maintenanceTypes'));
    }

    // Show the form for creating a new maintenance type
    public function create()
    {
        return view('maintenance_types.create');
    }

    // Store a newly created maintenance type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:maintenance_types,name|max:255',
        ]);

        MaintenanceType::create(['name' => $request->name]);

        return redirect()->route('maintenance-types.index')->with('success', 'Maintenance Type created successfully.');
    }

    // Show the form for editing a maintenance type
    public function edit(MaintenanceType $maintenanceType)
    {
        return view('maintenance_types.edit', compact('maintenanceType'));
    }

    // Update a maintenance type
    public function update(Request $request, MaintenanceType $maintenanceType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:maintenance_types,name,' . $maintenanceType->id,
        ]);

        $maintenanceType->update(['name' => $request->name]);

        return redirect()->route('maintenance-types.index')->with('success', 'Maintenance Type updated successfully.');
    }

    // Delete a maintenance type
    public function destroy(MaintenanceType $maintenanceType)
    {
        $maintenanceType->delete();
        return redirect()->route('maintenance-types.index')->with('success', 'Maintenance Type deleted successfully.');
    }
}
