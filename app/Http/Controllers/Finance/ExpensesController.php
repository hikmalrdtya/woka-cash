<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $expansesList = Expense::all();

        return view('finance.expenses.index', compact('expansesList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $projects = Project::all();
        return view('finance.expenses.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = auth()->user();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'project_id' => 'nullable|exists:projects,id',
            'amount' => 'required|numeric',
            'note_number' => 'nullable|string|max:255',
            'store_name' => 'nullable|string|max:255',
            'expense_date' => 'required|date',
            'receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'verified_by' => 'nullable|exists:users,id',
            'verified_at' => 'nullable|date',
        ]);

        if ($request->hasFile('receipt_file')) {
            $file = $request->file('receipt_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('receipts', $fileName, 'public');
            $expenseData['receipt_file'] = $filePath;
        }

        Expense::create([
            'user_id' => $user->id,
            'branch_id' => $request->branch_id,
            'project_id' => $request->project_id ?? null,
            'amount' => $request->amount,
            'note_number' => $request->note_number ?? null,
            'store_name' => $request->store_name ?? null,
            'expense_date' => now()->toDateString(),
            'receipt_file' => $expenseData['receipt_file'] ?? null,
            'verified_by' => $request->verified_by ?? null,
            'verified_at' => $request->verified_at ?? null,
        ]);

        return redirect()->route('finance.expenses.index')->with('success', 'Expense created successfully.');
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
