<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;


class ServiceController extends Controller
{
    // Display a listing of the branches.
    public function index()
    {
        $services = Service::all();
        return view('service.index', compact('services'));
    }

    // Show the form for creating a new branch.
    public function create()
    {
        return view('service.create');
    }

    // Store a newly created branch in the database.
    public function store(Request $request)
    {
        $request->validate([
            'ServiceTypeId' => 'required|unique:service',
            'ServiceTypeName' => 'required',
        ]);

        $services = new Service();
        $services->ServiceTypeId = $request->ServiceTypeId;
        $services->ServiceTypeName = $request->ServiceTypeName;
        $services->save();

        return redirect()->route('service.index')->with('success', 'Branch created successfully.');
    }

    // Display the specified branch.
    public function show($id)
    {
        $services = Service::findOrFail($id);
        return view('service.show', compact('services'));
    }

    // Show the form for editing the specified branch.
    public function edit($id)
    {
        $services = Service::findOrFail($id);
        return view('service.edit', compact('services'));
    }

    // Update the specified branch in the database.
    public function update(Request $request, $id)
    {
        $request->validate([
            'ServiceTypeId' => 'required|unique:service',
            'ServiceTypeName' => 'required',
        ]);

        $services = Service::findOrFail($id);
        $services->ServiceTypeId = $request->ServiceTypeId;
        $services->ServiceTypeName = $request->ServiceTypeName;
        $services->save();

        return redirect()->route('service.index')->with('success', 'service updated successfully.');
    }

    // Remove the specified branch from the database.
    public function destroy($id)
    {
        $services = Service::findOrFail($id);
        $services->delete();

        return redirect()->route('service.index')->with('success', 'service deleted successfully.');
    }

}
