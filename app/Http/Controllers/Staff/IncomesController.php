<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BranchUser;
use App\Models\Income;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();

        $branchIds = BranchUser::where('user_id', $user->id)->pluck('branch_id');
        $projects = Project::all();
        $Incomeslist = Income::where('user_id', $user->id)
            ->whereIn('branch_id', $branchIds)
            ->orderBy('date', 'desc')
            ->get();

        return view('staff.incomes.index', compact('Incomeslist', 'branchIds', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $branchId = BranchUser::where('user_id', $user->id)->value('branch_id');

        $request->validate([
            'amount' => 'required',
            'income_source' => 'required|in:project,other',
            'date' => 'required|date',
            'project_id' => 'required_if:income_source,project|nullable|exists:projects,id',
            'description' => 'required_if:income_source,other|nullable|string',
        ]);

        // Bersihkan format rupiah
        $cleanAmount = (int) str_replace(['Rp', '.', ',', ' '], '', $request->amount);

        Income::create([
            'user_id' => $user->id,
            'project_id' => $request->income_source === 'project' ? $request->project_id : null,
            'branch_id' => $branchId,
            'amount' => $cleanAmount,
            'description' => $request->income_source === 'other'
                ? $request->description
                : Project::find($request->project_id)?->name,
            'date' => $request->date,
        ]);

        return redirect()->route('staff.incomes.index')
            ->with('success', 'Income recorded successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
