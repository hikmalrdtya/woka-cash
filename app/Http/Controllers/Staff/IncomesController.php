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
        $projects = Project::whereDoesntHave('incomes')->get();
        return view('staff.incomes.create', compact('projects'));
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
    public function edit(Income $income)
    {
        //
        $projects = Project::whereDoesntHave('incomes')->orWhere('id', $income->project_id)->get();
        return view('staff.incomes.edit', compact('projects', 'income'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'nullable|string|required_if:income_source,other',
        ]);

        // Generate nilai description
        $description = null;

        if ($request->income_source === 'other') {
            // deskripsi dari input (bisa nullable)
            $description = $request->description;
        } else {
            // ambil nama project jika ada
            $project = Project::find($request->project_id);
            $description = $project?->name; // bisa null juga
        }

        // Format amount
        $cleanAmount = (int) str_replace(['Rp', '.', ',', ' '], '', $request->amount);

        // Update
        $income->update([
            'amount' => $cleanAmount,
            'date' => now(),
            'project_id' => $request->project_id,
            'description' => $description, // ini bisa null
        ]);

        return redirect()
            ->route('staff.incomes.index')
            ->with('success', 'Incomes successfully updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income) 
    {
        //
        if ($income) {
            $income->delete();
            return redirect()->back()->with('success', 'incomes successfuly deleted');
        }
        return redirect()->back()->with('error', 'incomes not found');
    }
}
