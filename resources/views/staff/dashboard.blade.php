@extends('layouts.main')

@section('title', 'Dashboard Staff | WokaCash')

@section('content')
<div class="p-6 space-y-6">
    {{-- Metric Cards --}}
    <div class="flex flex-wrap gap-6 mt-4">

        <!-- Total Income Card -->
        <div class="flex-1 min-w-[200px] rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208Z"/>
                </svg>
            </div>

            <div class="mt-5">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Income (Month)</span>
                <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </h4>
            </div>
        </div>

        <!-- Total Expense Card -->
        <div class="flex-1 min-w-[200px] rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M3 21V3h8v18H3Zm10 0V8h8v13h-8ZM6 6h2V5H6v1Zm0 3h2V8H6v1Zm0 3h2v-1H6v1Zm0 3h2v-1H6v1Zm10-6h2V9h-2v1Zm0 3h2v-1h-2v1Zm0 3h2v-1h-2v1Z"/>
                </svg>
            </div>

            <div class="mt-5">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Expense (Month)</span>
                <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </h4>
            </div>
        </div>

        <!-- Total Branch Card -->
        <div class="flex-1 min-w-[200px] rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M3 21V3h8v18H3Zm10 0V8h8v13h-8ZM6 6h2V5H6v1Zm0 3h2V8H6v1Zm0 3h2v-1H6v1Zm0 3h2v-1H6v1Zm10-6h2V9h-2v1Zm0 3h2v-1h-2v1Zm0 3h2v-1h-2v1Z"/>
                </svg>
            </div>

            <div class="mt-5">
                <span class="text-sm text-gray-500 dark:text-gray-400">Waiting Approval</span>
                <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                    {{ $pendingRequests }}
                </h4>
            </div>
        </div>

    </div>
</div>
@endsection
