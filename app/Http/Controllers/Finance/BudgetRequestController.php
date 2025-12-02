<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BudgetRequest;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $branches = Branch::all();

        $branchId = $request->branch_id;
        $query = BudgetRequest::with('branch', 'user')
            ->where('status', 'pending')
            ->latest();


        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $budgetList = $query->get();

        return view('finance.budget_request.index', compact('budgetList', 'branches', 'branchId'));
    }

    public function approve($id)
    {
        $budget = BudgetRequest::findOrFail($id);

        $budget->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        Expense::create([
            'budget_request_id' => $budget->id,
            'user_id' => $budget->user_id,
            'branch_id' => $budget->branch_id,
            'project_id' => null,
            'amount' => $budget->amount,
            'note_number' => null,
            'store_name' => null,
            'expense_date' => now()->toDateString(),
            'receipt_file' => null,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Budget approved and moved to expenses.');
    }


    public function reject($id)
    {
        $budget = BudgetRequest::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $budget
        ]);
    }

    public function rejectUpdate(Request $request, $id)
    {
        $request->validate([
            'amount_usulan' => 'required',
        ]);

        $cleanAmount = str_replace('.', '', $request->amount_usulan);

        if (!is_numeric($cleanAmount)) {
            return back()->with('error', 'Format angka tidak valid.');
        }

        $budget = BudgetRequest::findOrFail($id);

        $budget->update([
            'amount' => $cleanAmount,
            'status' => 'pending',
        ]);

        return redirect()->route('finance.budget_requests.index')
            ->with('success', 'Usulan biaya berhasil diperbarui.');
    }



}
