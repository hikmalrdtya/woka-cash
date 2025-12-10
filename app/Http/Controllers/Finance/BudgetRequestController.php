<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BudgetRequest;
use App\Models\Expense;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetRequestController extends Controller
{
    public function index(Request $request)
    {
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

        // === NOTIFIKASI UNTUK STAFF ===
        Notification::create([
            'user_id' => $budget->user_id,
            'title' => 'Budget Request Approved',
            'message' => 'Budget request ' . $budget->user->name . ' telah disetujui oleh ' . Auth::user()->name . '.',
        ]);

        // === NOTIFIKASI UNTUK FINANCE ===
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Konfirmasi Approval',
            'message' => "Anda menyetujui budget request milik " . $budget->user->name,
        ]);

        // PINDAHKAN KE EXPENSES
        Expense::create([
            'budget_request_id' => $budget->id,
            'user_id' => $budget->user_id,
            'branch_id' => $budget->branch_id,
            'amount' => $budget->amount,
            'expense_date' => now()->toDateString(),
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
            'reason' => 'required|string|max:255', // alasan wajib
        ]);

        $cleanAmount = str_replace('.', '', $request->amount_usulan);

        if (!is_numeric($cleanAmount)) {
            return back()->with('error', 'Format angka tidak valid.');
        }

        $budget = BudgetRequest::findOrFail($id);

        // UPDATE STATUS DAN ALASAN PENOLAKAN
        $budget->update([
            'amount' => $cleanAmount,
            'status' => 'rejected',
            'rejected_by' => auth()->id(),
            'rejected_at' => now(),
            'reject_reason' => $request->reason,
        ]);

        // === NOTIFIKASI UNTUK STAFF ===
        Notification::create([
            'user_id' => $budget->user_id,
            'title' => 'Budget Request Ditolak',
            'message' => 'Budget request Anda ditolak oleh ' . Auth::user()->name .
                ' dengan alasan: ' . $request->reason,
        ]);

        // === NOTIFIKASI UNTUK FINANCE ===
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Konfirmasi Penolakan',
            'message' => "Anda telah menolak budget request milik " . $budget->user->name,
        ]);

        return redirect()->route('finance.budget_requests.index')
            ->with('success', 'Request berhasil ditolak dan notifikasi dikirim.');
    }




    public function updateStatus(Request $request, BudgetRequest $budget)
    {
        $budget->update([
            'status' => $request->status,
        ]);

        Notification::create([
            'user_id' => $budget->user_id, // staff yang membuat
            'title' => 'Status Budget Request',
            'message' => "Budget request '{$budget->title}' telah {$budget->status} oleh Finance.",
            'url' => route('staff.budget_requests.index'),
        ]);


        // === 2. Notifikasi ke Finance ===
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Konfirmasi Request',
            'message' => "Anda telah mengubah status request milik " . $budget->user->name . " menjadi " . $request->status,
        ]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }
}
