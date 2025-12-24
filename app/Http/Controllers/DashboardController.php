<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchUser;
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
            $branchCount = Branch::count();

            $monthlyTarget = 20000;
            $thisMonthRevenue = 15110;
            $lastMonthRevenue = 12000;
            $todayIncome = 3287;

            $percent = ($thisMonthRevenue / $monthlyTarget) * 100;

            $growth = 0;
            if ($lastMonthRevenue > 0) {
                $growth = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
            }

            $months = [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ];

            // ===============================
            //   FIX OVERVIEW INCOME
            // ===============================
            $overviewIncomeRaw = Income::whereNotNull('date')
                ->selectRaw('MONTH(date) as month, SUM(amount) as total')
                ->groupBy('month')
                ->get();

            $overviewExpenseRaw = Expense::whereNotNull('expense_date')
                ->selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
                ->groupBy('month')
                ->get();

            // build array 1..12 stabil
            $incomeAll = array_fill(1, 12, 0);
            foreach ($overviewIncomeRaw as $row) {
                $m = (int) $row->month;
                if ($m >= 1 && $m <= 12) {
                    $incomeAll[$m] = (float) $row->total;
                }
            }
            $incomeAll = array_values($incomeAll);

            $expenseAll = array_fill(1, 12, 0);
            foreach ($overviewExpenseRaw as $row) {
                $m = (int) $row->month;
                if ($m >= 1 && $m <= 12) {
                    $expenseAll[$m] = (float) $row->total;
                }
            }
            $expenseAll = array_values($expenseAll);

            // ===============================
            //   FIX PER BRANCH CHART
            // ===============================
            $branches = Branch::all();
            $branchCharts = [];

            foreach ($branches as $branch) {

                $incRaw = Income::where('branch_id', $branch->id)
                    ->whereNotNull('date')
                    ->selectRaw('MONTH(date) as month, SUM(amount) as total')
                    ->groupBy('month')
                    ->get();

                $expRaw = Expense::where('branch_id', $branch->id)
                    ->whereNotNull('expense_date')
                    ->selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
                    ->groupBy('month')
                    ->get();

                // prepare array 1..12 = 0
                $incArr = array_fill(1, 12, 0);
                foreach ($incRaw as $r) {
                    $m = (int) $r->month;
                    if ($m >= 1 && $m <= 12) {
                        $incArr[$m] = (float) $r->total;
                    }
                }

                $expArr = array_fill(1, 12, 0);
                foreach ($expRaw as $r) {
                    $m = (int) $r->month;
                    if ($m >= 1 && $m <= 12) {
                        $expArr[$m] = (float) $r->total;
                    }
                }

                $branchCharts[$branch->id] = [
                    'name' => $branch->name,
                    'income' => array_values($incArr),
                    'expense' => array_values($expArr),
                ];
            }

            // ===============================
            //   PIE CHART PER BRANCH
            // ===============================
            $incomeGrouped = Income::select('branch_id', DB::raw('SUM(amount) as total'))
                ->groupBy('branch_id')
                ->pluck('total', 'branch_id');

            $expenseGrouped = Expense::select('branch_id', DB::raw('SUM(amount) as total'))
                ->groupBy('branch_id')
                ->pluck('total', 'branch_id');

            $branches = Branch::select('id', 'name')->get();
            $labels = $branches->pluck('name')->toArray();

            $income = $branches->map(fn($b) => $incomeGrouped[$b->id] ?? 0)->toArray();
            $expense = $branches->map(fn($b) => $expenseGrouped[$b->id] ?? 0)->toArray();

            // ===============================
            //   DEBUG (HAPUS SETELAH FIX)
            // ===============================
            // dd($incomeAll, $expenseAll, $branchCharts);

            return view('admin.dashboard', [
                'user' => $user,
                'staff' => $staff,
                'branchCount' => $branchCount,

                'percent' => round($percent, 2),
                'growth' => round($growth, 2),
                'target' => $monthlyTarget,
                'revenue' => $thisMonthRevenue,
                'today' => $todayIncome,

                'months' => $months,
                'overviewIncome' => $incomeAll,
                'overviewExpense' => $expenseAll,
                'branchCharts' => $branchCharts,

                'labels' => $labels,
                'income' => $income,
                'expense' => $expense,
            ]);
        } elseif ($user->role === 'staff') {

            // Hitung Persentase Perbandingan Hari Ini vs Kemarin
            //Income
            $today = Carbon::today()->format('Y-m-d');
            $yesterday = Carbon::yesterday()->format('Y-m-d');

            // === INCOME ===
            $incomeToday = Income::where('branch_id', Auth::user()->branch_id)
                ->whereDate('date', $today)->sum('amount');
            $incomeYesterday = Income::where('branch_id', Auth::user()->branch_id)
                ->whereDate('date', $yesterday)->sum('amount');

            $incomeChange = 0;
            if ($incomeYesterday > 0) {
                $incomeChange = (($incomeToday - $incomeYesterday) / $incomeYesterday) * 100;
            }

            //Expenses
            $expenseToday = Expense::where('branch_id', Auth::user()->branch_id)
                ->whereDate('expense_date', $today)->sum('amount');
            $expenseYesterday = Expense::where('branch_id', Auth::user()->branch_id)
                ->whereDate('expense_date', $yesterday)->sum('amount');

            $expenseChange = 0;
            if ($expenseYesterday > 0) {
                $expenseChange = (($expenseToday - $expenseYesterday) / $expenseYesterday) * 100;
            }

            // and Hitung Persentase Perbandingan Hari Ini vs Kemarin

            // Ambil branch yang diikuti staff dari tabel branch_users
            $branchUser = BranchUser::where('user_id', $user->id)->first();

            if (!$branchUser) {
                abort(403, 'Anda belum terdaftar di cabang manapun.');
            }

            $branchId = $branchUser->branch_id;

            $totalIncome = Income::where('branch_id', $branchId)->whereDate('date', $today)->sum('amount');
            $totalExpense = Expense::where('branch_id', $branchId)->whereDate('expense_date', $today)->sum('amount');
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
                'expenseChange',
                'incomeChange',
                'totalIncome',
                'totalExpense',
                'netBalance',
                'pendingRequests',
                'latestIncome',
                'latestExpense'
            ));
        } elseif ($user->role === 'finance') {

            $today = Carbon::today()->format('Y-m-d');
            $yesterday = Carbon::yesterday()->format('Y-m-d');

            $incomeToday = Income::whereDate('date', $today)->sum('amount');
            $incomeYesterday = Income::whereDate('date', $yesterday)->sum('amount');

            $incomeChange = 0;
            if ($incomeYesterday > 0) {
                $incomeChange = (($incomeToday - $incomeYesterday) / $incomeYesterday) * 100;
            }

            $expenseToday = Expense::whereDate('expense_date', $today)->sum('amount');
            $expenseYesterday = Expense::whereDate('expense_date', $yesterday)->sum('amount');

            $expenseChange = 0;
            if ($expenseYesterday > 0) {
                $expenseChange = (($expenseToday - $expenseYesterday) / $expenseYesterday) * 100;
            }

            $netBalance = $incomeToday - $expenseToday;

            return view('finance.dashboard', compact(
                'incomeToday',
                'incomeYesterday',
                'incomeChange',
                'expenseToday',
                'expenseYesterday',
                'expenseChange',
                'netBalance'
            ));
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
