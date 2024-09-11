<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    // Display a listing of the branches.
    public function index()
    {
        $branches = Branch::all();
        return view('branches.index', compact('branches'));
    }

    // Show the form for creating a new branch.
    public function create()
    {
        return view('branches.create');
    }

    // Store a newly created branch in the database.
    public function store(Request $request)
    {
        $request->validate([
            'BranchID' => 'required|unique:branches',
            'name' => 'required',
            'address' => 'required',
            'telephone' => 'required',
        ]);

        $branch = new Branch();
        $branch->BranchID = $request->BranchID;
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->telephone = $request->telephone;
        $branch->save();

        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    // Display the specified branch.
    public function show($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branches.show', compact('branch'));
    }

    // Show the form for editing the specified branch.
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branches.edit', compact('branch'));
    }

    // Update the specified branch in the database.
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'telephone' => 'required',
        ]);

        $branch = Branch::findOrFail($id);
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->telephone = $request->telephone;
        $branch->save();

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    // Remove the specified branch from the database.
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }

}
