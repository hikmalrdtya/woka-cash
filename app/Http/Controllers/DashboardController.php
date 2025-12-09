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

    public function filteredSummary(Request $request)
    {
        $user = Auth::user();

        // Khusus staff → ambil hanya cabang dia
        $branch = Branch::where('user_id', $user->id)->first();
        if (!$branch) {
            return response()->json(['error' => 'Branch not found'], 404);
        }
        $branchId = $branch->id;

        $range = $request->range ?? 'monthly'; // default

        if ($range === 'daily') {
            $labels = [];
            $incomes = [];
            $expenses = [];

            // 7 hari terakhir
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');

                $labels[] = Carbon::now()->subDays($i)->format('d M');

                $incomes[] = Income::where('branch_id', $branchId)
                    ->whereDate('date', $date)
                    ->sum('amount');

                $expenses[] = Expense::where('branch_id', $branchId)
                    ->whereDate('expense_date', $date)
                    ->sum('amount');
            }
        } elseif ($range === 'monthly') {
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
                ->where('branch_id', $branchId)
                ->groupBy('month')
                ->get();

            foreach ($incomeData as $row) {
                $incomes[$row->month - 1] = (int) $row->total;
            }

            $expenseData = Expense::selectRaw('MONTH(expense_date) AS month, SUM(amount) AS total')
                ->where('branch_id', $branchId)
                ->groupBy('month')
                ->get();

            foreach ($expenseData as $row) {
                $expenses[$row->month - 1] = (int) $row->total;
            }
        } elseif ($range === 'yearly') {
            $currentYear = Carbon::now()->year;
            $startYear = $currentYear - 4; // grafik 5 tahun

            $labels = [];
            $incomes = [];
            $expenses = [];

            for ($year = $startYear; $year <= $currentYear; $year++) {
                $labels[] = $year;

                $incomes[] = Income::where('branch_id', $branchId)
                    ->whereYear('date', $year)
                    ->sum('amount');

                $expenses[] = Expense::where('branch_id', $branchId)
                    ->whereYear('expense_date', $year)
                    ->sum('amount');
            }
        }

        return response()->json([
            'labels' => $labels,
            'incomes' => $incomes,
            'expenses' => $expenses,
        ]);
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
