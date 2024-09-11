<?php

namespace App\Http\Controllers;

use App\Models\SubService;
use App\Models\Service; // Make sure to include this for fetching services
use Illuminate\Http\Request;

class SubServiceController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $subServices = SubService::all();
        return view('sub_services.index', compact('subServices'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        // Fetch all services to populate the dropdown
        $services = Service::all();
        return view('sub_services.create', compact('services'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'SubServiceId' => 'required|unique:sub_services',
            'SubServiceName' => 'required|string|max:255',
            'ServiceTypeId' => 'required|exists:services,ServiceTypeId', // Note the table name is 'services'
        ]);

        SubService::create($request->all());

        return redirect()->route('sub-services.index')
            ->with('success', 'SubService created successfully.');
    }

    // Display the specified resource
    public function show($id)
    {
        $subService = SubService::findOrFail($id);
        return view('sub_services.show', compact('subService'));
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $subService = SubService::findOrFail($id);
        $services = Service::all(); // Fetch all services for dropdown
        return view('sub_services.edit', compact('subService', 'services'));
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'SubServiceName' => 'required|string|max:255',
            'ServiceTypeId' => 'required|exists:services,ServiceTypeId', // Note the table name is 'services'
        ]);

        $subService = SubService::findOrFail($id);
        $subService->update($request->all());

        return redirect()->route('sub-services.index')
            ->with('success', 'SubService updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $subService = SubService::findOrFail($id);
        $subService->delete();

        return redirect()->route('sub-services.index')
            ->with('success', 'SubService deleted successfully.');
    }
}
