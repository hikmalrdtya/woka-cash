<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BudgetRequest;
use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
        if ($user->role === 'admin') {
            $staff = User::whereIn('role', ['staff', 'finance'])->count();
            $branch = Branch::count();
            return view('admin.dashboard', compact(['user', 'staff', 'branch']));
        } elseif ($user->role === 'staff') {

            $branches = Branch::where('user_id', $user->id)->first();
            $branchId = $branches->id;

            $totalIncome = Income::where('branch_id', $branchId)->sum('amount');
            $totalExpense = Expense::where('branch_id', $branchId)->sum('amount');
            $netBalance = $totalIncome - $totalExpense;
            $pendingRequests = BudgetRequest::where('branch_id', $branchId)
                ->where('status', 'pending')
                ->count();


            $latestIncome = Income::where('branch_id', $branchId)
                ->with('project')
                ->orderByDesc('date')
                ->limit(5)
                ->get();

            $latestExpense = Expense::where('branch_id', $branchId)
                ->orderByDesc('expense_date')
                ->limit(5)
                ->get();

            return view('staff.dashboard', compact(
                'totalIncome',
                'totalExpense',
                'netBalance',
                'pendingRequests',
                'latestIncome',
                'latestExpense',
            ));
        } elseif ($user->role === 'finance') {
            return view('finance.dashboard');
        }
    }

    public function monthlySummary()
    {
        $labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        $incomes = array_fill(0, 12, 0);
        $expenses = array_fill(0, 12, 0);

        $incomeData = Income::selectRaw('MONTH(date) AS month, SUM(amount) AS total')
            ->groupBy('month')
            ->get();

        foreach ($incomeData as $row) {
            $incomes[$row->month - 1] = (int) $row->total;
        }

        $expenseData = Expense::selectRaw('MONTH(expense_date) AS month, SUM(amount) AS total')
            ->groupBy('month')
            ->get();

        foreach ($expenseData as $row) {
            $expenses[$row->month - 1] = (int) $row->total;
        }

        return response()->json([
            'labels' => $labels,
            'incomes' => array_values($incomes),
            'expenses' => array_values($expenses),
        ]);
    }

    
}
