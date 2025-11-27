<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchUser;
use App\Models\User;
use Illuminate\Http\Request;

class BranchUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BranchUser::query()->with('user');

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $branchUsers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.branch-users.index', compact('branchUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::orderBy('created_at', 'desc')->get();
        $users = User::whereIn('role', ['finance', 'staff'])->get();

        return view('admin.branch-users.create', compact(['branches', 'users']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'branch' => 'required|string',
            'user' => 'required|string',
            'role_in_branch' => 'nullable|string|max:255'
        ]);

        $role = null;

        if (!empty($data['role_in_branch'])) {
            $role = $data['role_in_branch'];
        }

        BranchUser::create([
            'branch_id' => $data['branch'],
            'user_id' => $data['user'],
            'role_in_branch' => $role
        ]);

        return redirect()->route('admin.branchUser.index')->with('success', 'Staff successfuly added');
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
    public function edit(BranchUser $branchUser)
    {
        $users = User::whereIn('role', ['finance', 'staff'])->get();
        $branches = Branch::orderBy('created_at', 'desc')->get();
        return view('admin.branch-users.edit', compact(['users', 'branches', 'branchUser']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BranchUser $branchUser)
    {
        $data = $request->validate([
            'branch' => 'required',
            'user' => 'required',
            'role_in_branch' => 'nullable|string|max:255'
        ]);

        $data['role_in_branch'] = $request->role_in_branch ?: null;

        $branchUser->update($data);

        return redirect()->route('admin.branchUser.index')
            ->with('success', 'Staff successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchUser $branchUser)
    {
        if ($branchUser) {
            $branchUser->delete();
            return redirect()->back()->with('success', 'Staff successfuly deleted');
        }

        return redirect()->back()->with('error', 'Staff not found');
    }
}
