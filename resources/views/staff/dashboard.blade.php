@extends('layouts.main')

@section('title', 'Dashboard Staff | WokaCash')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Dashboard Staff</h1>
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- Total Income --}}
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Income (Month)</p>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </h2>
            </div>

            {{-- Total Expense --}}
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Expense (Month)</p>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </h2>
            </div>

            {{-- Net Balance --}}
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                <p class="text-sm text-gray-500 dark:text-gray-400">Net Balance</p>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Rp {{ number_format($netBalance, 0, ',', '.') }}
                </h2>
            </div>

            {{-- Pending Approval --}}
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                <p class="text-sm text-gray-500 dark:text-gray-400">Waiting Approval</p>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $pendingRequests }} Items
                </h2>
            </div>

        </div>

        {{-- Latest Income & Expense --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Latest Income --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Latest Income</h3>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b dark:border-gray-700">
                            <th class="py-2 text-left">Date</th>
                            <th class="py-2 text-left">Amount</th>
                            <th class="py-2 text-left">Source</th>
                            <th class="py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestIncome as $row)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="py-2"></td>
                                <td class="py-2">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                                <td class="py-2">
                                    {{ $row->income_source === 'project' ? $row->project->name : 'Other' }}
                                </td>
                                <td class="py-2">
                                    <span class="px-3 py-1 text-xs rounded-full
                                            @if($row->status == 'pending') bg-yellow-100 text-yellow-700
                                            @elseif($row->status == 'approved') bg-green-100 text-green-700
                                            @else bg-red-100 text-red-700 @endif
                                        ">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            {{-- Latest Expense --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Latest Expense</h3>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b dark:border-gray-700">
                            <th class="py-2 text-left">Date</th>
                            <th class="py-2 text-left">Amount</th>
                            <th class="py-2 text-left">Category</th>
                            <th class="py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestExpense as $row)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="py-2">{{ $row->date->format('d M') }}</td>
                                <td class="py-2">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                                <td class="py-2">{{ ucfirst($row->category) }}</td>
                                <td class="py-2">
                                    <span class="px-3 py-1 text-xs rounded-full
                                            @if($row->status == 'pending') bg-yellow-100 text-yellow-700
                                            @elseif($row->status == 'approved') bg-green-100 text-green-700
                                            @else bg-red-100 text-red-700 @endif
                                        ">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
@endsection