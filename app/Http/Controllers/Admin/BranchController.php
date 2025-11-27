<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Branch::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $branches = $query->latest()->paginate(10)->withQueryString();

        return view('admin.branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereIn('role', ['finance', 'staff'])->get();
        return view('admin.branch.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user' => 'required|string',
            'name_branches' => 'required|string|max:255',
            'address' => 'required',
        ]);

        Branch::create([
            'user_id' => $data['user'],
            'name' => $data['name_branches'],
            'address' => $data['address']
        ]);

        return redirect()->route('admin.branch.index')->with('success', 'Branch successfuly added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        $users = User::whereIn('role', ['finance', 'staff'])->get();
        return view('admin.branch.edit', compact(['branch', 'users']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'user' => 'required|string',
            'name_branches' => 'required|string|max:255',
            'address' => 'required',
        ]);

        $branch->update([
            'user_id' => $data['user'],
            'name' => $data['name_branches'],
            'address' => $data['address']
        ]);

        return redirect()->route('admin.branch.index')->with('success', 'Branch successfuly updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        if ($branch) {
            $branch->delete();
            return redirect()->back()->with('success', 'Branch successfuly deleted');
        }
        return redirect()->back()->with('error', 'Branch not found');
    }
}
