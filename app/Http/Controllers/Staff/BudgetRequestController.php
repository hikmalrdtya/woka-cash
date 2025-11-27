<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchUser;
use App\Models\BudgetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user()->id;
        $branchIds = BranchUser::where('user_id', $user)->pluck('branch_id');
        $requests = BudgetRequest::where('user_id', auth()->id())->latest()->get();
        $budgetList = BudgetRequest::with('branch')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view("staff.budget_request.index", compact([
            'requests',
            'branchIds',
            'budgetList'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $branches = Branch::get();
        $budgetList = BudgetRequest::with('branch')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('staff.budget_request.create', compact([
            'budgetList',
            'branches'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'title' => 'required|string|max:255',
            'amount' => 'required',
            'note' => 'nullable|string',
            'date_submission' => 'required|date',
        ]);

        $cleanAmount = str_replace('.', '', $request->amount);

        BudgetRequest::create([
            'user_id' => auth()->id(),
            'branch_id' => $request->branch_id,
            'title' => $request->title,
            'amount' => $cleanAmount,
            'note' => $request->note,
            'status' => 'pending',
            'approved_by' => null,
            'date_submission' => $request->date_submission,
        ]);
        return redirect()->route('staff.budget_requests.index')
            ->with('success', 'Budget request berhasil dikirim.');
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
