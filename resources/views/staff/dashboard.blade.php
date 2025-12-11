@extends('layouts.main')

@section('title', 'Dashboard Admin | WokaCash')

@section('content')

    <body
        x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
        x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
                                                                $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
        :class="{ 'dark bg-gray-900': darkMode === true }">
        <!-- ===== Preloader Start ===== -->
        <div x-show="loaded"
            x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
            class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
            <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent">
            </div>
        </div>

        <!-- ===== Preloader End ===== -->

        <!-- ===== Page Wrapper Start ===== -->
        <div class="flex h-screen overflow-hidden">

            <!-- ===== Content Area Start ===== -->
            <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
                <!-- Small Device Overlay Start -->
                <div @click="sidebarToggle = false" :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
                    class="fixed w-full h-screen z-9 bg-gray-900/50"></div>
                <!-- Small Device Overlay End -->

                <!-- ===== Main Content Start ===== -->
                <main>
                    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                        <div class="grid grid-cols-12 gap-4 md:gap-6">
                            <div class="col-span-12 space-y-6 xl:col-span-7">
                                <!-- Metric Group One -->
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
                                    <!-- Metric Item Start -->
                                    <div
                                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">

                                                <!-- Bars -->
                                                <rect x="4" y="12" width="3" height="7" rx="1"></rect>
                                                <rect x="9" y="9" width="3" height="10" rx="1"></rect>
                                                <rect x="14" y="6" width="3" height="13" rx="1"></rect>
                                            </svg>
                                        </div>

                                        <div class="mt-5 flex items-end justify-between">
                                            <div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Incomes</span>
                                                <h4 class="mt-2 text-xl font-bold text-gray-800 dark:text-white/90"> Rp
                                                    {{ number_format($totalIncome, 0, ',', '.') }}
                                                </h4>
                                            </div>

                                            @php
                                                $isIncomeUp = $incomeChange >= 0;
                                            @endphp

                                            <span class="flex items-center gap-1 rounded-full 
                                                                {{ $isIncomeUp
        ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
        : 'bg-danger-50 text-danger-600 dark:bg-danger-500/15 dark:text-danger-400' }}
                                                                py-0.5 pl-2 pr-2.5 text-sm font-medium">

                                                {{-- Icon --}}
                                                @if($isIncomeUp)
                                                    {{-- Arrow Up --}}
                                                    <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.56462 1.62393C5.70193 1.47072 5.90135 1.37432 6.12329 1.37432C6.1236 1.37432 6.12391 1.37432 
                                                                                    6.12422 1.37432C6.31631 1.37415 6.50845 1.44731 6.65505 1.59381L9.65514 4.5918C9.94814 4.88459 
                                                                                    9.94831 5.35947 9.65552 5.65246C9.36273 5.94546 8.88785 5.94562 8.59486 5.65283L6.87329 3.93247V10.125
                                                                                    C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125V3.93578
                                                                                    L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65248C2.3017 5.35949 2.30185 4.88462 
                                                                                    2.59484 4.59182L5.56462 1.62393Z" />
                                                    </svg>
                                                @else
                                                    {{-- Arrow Down --}}
                                                    <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M6.43538 10.3761C6.29807 10.5293 6.09865 10.6257 5.87671 10.6257C5.8764 10.6257 5.87609 
                                                                                    10.6257 5.87578 10.6257C5.68369 10.6259 5.49155 10.5527 5.34495 10.4062L2.34486 7.4082C2.05186 
                                                                                    7.11541 2.05169 6.64053 2.34448 6.34754C2.63727 6.05454 3.11215 6.05438 3.40514 6.34717L5.12671 8.06753
                                                                                    V1.875C5.12671 1.46077 5.46249 1.125 5.87671 1.125C6.29092 1.125 6.62671 1.46077 6.62671 1.875
                                                                                    V8.06422L8.34484 6.34718C8.63782 6.05438 9.1127 6.05453 9.4055 6.34752C9.6983 6.64051 9.69815 
                                                                                    7.11538 9.40516 7.40818L6.43538 10.3761Z" />
                                                    </svg>
                                                @endif

                                                {{ number_format($incomeChange, 2) }}%
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Metric Item End -->

                                    <!-- Metric Item Start -->
                                    <div
                                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <!-- Dompet -->
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 10v6a2.5 2.5 0 0 0 2.5 2.5h13A2.5 2.5 0 0 0 21 16v-6A2.5 2.5 0 0 0 18.5 7h-13A2.5 2.5 0 0 0 3 10Z" />

                                                <!-- Kancing dompet -->
                                                <circle cx="16.5" cy="13" r="1" />

                                                <!-- Uang kertas keluar -->
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M7 7L9.5 3.5h7L19 7H7Z" />
                                                <circle cx="13" cy="5.25" r="1" />
                                            </svg>
                                        </div>

                                        <div class="mt-5 flex items-end justify-between">
                                            <div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Expenses</span>
                                                <h4 class="mt-2 text-xl  font-bold text-gray-800 dark:text-white/90"> Rp
                                                    {{ number_format($totalExpense, 0, ',', '.') }}
                                                </h4>
                                            </div>

                                            <span class="flex items-center gap-1 rounded-full 
                                                                {{ $isExpenseUp = $expenseChange >= 0
        ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
        : 'bg-danger-50 text-danger-600 dark:bg-danger-500/15 dark:text-danger-400' }}
                                                                py-0.5 pl-2 pr-2.5 text-sm font-medium">

                                                @if($isExpenseUp)
                                                    {{-- Arrow Up --}}
                                                    <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.56462 1.62393C5.70193 1.47072 5.90135 1.37432 6.12329 1.37432C6.1236 1.37432 6.12391 1.37432 
                                                                                    6.12422 1.37432C6.31631 1.37415 6.50845 1.44731 6.65505 1.59381L9.65514 4.5918C9.94814 4.88459 
                                                                                    9.94831 5.35947 9.65552 5.65246C9.36273 5.94546 8.88785 5.94562 8.59486 5.65283L6.87329 3.93247V10.125
                                                                                    C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125V3.93578
                                                                                    L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65248C2.3017 5.35949 2.30185 4.88462 
                                                                                    2.59484 4.59182L5.56462 1.62393Z" />
                                                    </svg>
                                                @else
                                                    {{-- Arrow Down --}}
                                                    <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M6.43538 10.3761C6.29807 10.5293 6.09865 10.6257 5.87671 10.6257C5.8764 10.6257 5.87609 
                                                                                    10.6257 5.87578 10.6257C5.68369 10.6259 5.49155 10.5527 5.34495 10.4062L2.34486 7.4082C2.05186 
                                                                                    7.11541 2.05169 6.64053 2.34448 6.34754C2.63727 6.05454 3.11215 6.05438 3.40514 6.34717L5.12671 8.06753
                                                                                    V1.875C5.12671 1.46077 5.46249 1.125 5.87671 1.125C6.29092 1.125 6.62671 1.46077 6.62671 1.875
                                                                                    V8.06422L8.34484 6.34718C8.63782 6.05438 9.1127 6.05453 9.4055 6.34752C9.6983 6.64051 9.69815 
                                                                                    7.11538 9.40516 7.40818L6.43538 10.3761Z" />
                                                    </svg>
                                                @endif

                                                {{ number_format($expenseChange, 2) }}%
                                            </span>

                                        </div>
                                    </div>
                                    <!-- Metric Item End -->
                                </div>
                                <!-- Metric Group One -->
                                {{-- Latest Income & Expense --}}
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                                    {{-- Latest Income --}}
                                    <div
                                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-5">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Latest Income
                                        </h3>

                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                                <tr>
                                                    <th class="py-3 px-2 text-left">Date</th>
                                                    <th class="py-3 px-2 text-left">Amount</th>
                                                    <th class="py-3 px-2 text-left">Source</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($latestIncome as $row)
                                                    <tr
                                                        class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                                        <td class="py-3 px-2">
                                                            {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                                                        </td>
                                                        <td class="py-3 px-2">Rp {{ number_format($row->amount, 0, ',', '.') }}
                                                        </td>
                                                        <td class="py-3 px-2">
                                                            <span
                                                                class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">
                                                                {{ $row->project_id != null ? 'Project' : 'Other' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                                    {{-- Latest Expense --}}
                                    <div
                                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-5">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Latest Expense
                                        </h3>

                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                                <tr>
                                                    <th class="py-4 px-3 text-center">Date</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Category</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($latestExpense as $row)
                                                    <tr
                                                        class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                                        <td class="py-4 px-3 text-center">
                                                            {{ \Carbon\Carbon::parse($row->expense_date)->format('d M Y') }}
                                                        </td>
                                                        <td class="text-center">Rp
                                                            {{ number_format($row->amount, 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ ucfirst($row->budgetRequest->title ?? 'N/A') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="inline-flex items-center justify-center gap-1 rounded-full
                                                                                                        @if($row->budgetRequest->status == 'pending') bg-warning-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-warning-600 dark:bg-warning-500/15 dark:text-orange-400
                                                                                                        @elseif($row->budgetRequest->status == 'approved') bg-success-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500
                                                                                                        @elseif($row->budgetRequest->status == 'rejected') bg-error-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500
                                                                                                        @else bg-gray-100 text-gray-700 
                                                                                                        @endif
                                                                                                        ">
                                                                @if($row->budgetRequest->status == 'approved')
                                                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M20 6L9 17l-5-5" />
                                                                    </svg>
                                                                @elseif($row->budgetRequest->status == 'pending')
                                                                    <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">

                                                                        <!-- Minimal Clock -->
                                                                        <circle cx="12" cy="12" r="9" />
                                                                        <path d="M12 7.5v4.7l2.2 1.3" />
                                                                    </svg>

                                                                @elseif($row->budgetRequest->status == 'rejected')
                                                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <line x1="18" y1="6" x2="6" y2="18" />
                                                                        <line x1="6" y1="6" x2="18" y2="18" />
                                                                    </svg>

                                                                @endif

                                                                {{ ucfirst($row->budgetRequest->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="col-span-12 xl:col-span-5">
                                <!-- ====== Chart Two Start -->
                                <div
                                    class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/[0.03]">
                                    <div class="shadow-default rounded-2xl bg-white px-5 pb-11 pt-5 dark:bg-gray-900">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                                    Monthly Target
                                                </h3>
                                                <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                                                    Target you’ve set for each month
                                                </p>
                                            </div>
                                            <div x-data="{ openDropDown: false }" class="relative h-fit">
                                                <button @click="openDropDown = !openDropDown"
                                                    :class="openDropDown ? 'text-gray-700 dark:text-white' :
                                                                                                                    'text-gray-400 hover:text-gray-700 dark:hover:text-white'">
                                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"
                                                            fill="" />
                                                    </svg>
                                                </button>
                                                <div x-show="openDropDown" @click.outside="openDropDown = false"
                                                    class="absolute right-0 top-full z-40 w-40 space-y-1 rounded-2xl border border-gray-200 bg-white p-2 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark">
                                                    <button
                                                        class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                                        View More
                                                    </button>
                                                    <button
                                                        class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative max-h-[195px]">
                                            <div id="chartTwo" class="h-full"></div>
                                            <span
                                                class="absolute left-1/2 top-[85%] -translate-x-1/2 -translate-y-[85%] rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">+10%</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5">
                                        <div>
                                            <p
                                                class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                                                Target
                                            </p>
                                            <p
                                                class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                                                $20K
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M7.26816 13.6632C7.4056 13.8192 7.60686 13.9176 7.8311 13.9176C7.83148 13.9176 7.83187 13.9176 7.83226 13.9176C8.02445 13.9178 8.21671 13.8447 8.36339 13.6981L12.3635 9.70076C12.6565 9.40797 12.6567 8.9331 12.3639 8.6401C12.0711 8.34711 11.5962 8.34694 11.3032 8.63973L8.5811 11.36L8.5811 2.5C8.5811 2.08579 8.24531 1.75 7.8311 1.75C7.41688 1.75 7.0811 2.08579 7.0811 2.5L7.0811 11.3556L4.36354 8.63975C4.07055 8.34695 3.59568 8.3471 3.30288 8.64009C3.01008 8.93307 3.01023 9.40794 3.30321 9.70075L7.26816 13.6632Z"
                                                        fill="#D92D20" />
                                                </svg>
                                            </p>
                                        </div>

                                        <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

                                        <div>
                                            <p
                                                class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                                                Revenue
                                            </p>
                                            <p
                                                class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                                                $20K
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M7.60141 2.33683C7.73885 2.18084 7.9401 2.08243 8.16435 2.08243C8.16475 2.08243 8.16516 2.08243 8.16556 2.08243C8.35773 2.08219 8.54998 2.15535 8.69664 2.30191L12.6968 6.29924C12.9898 6.59203 12.9899 7.0669 12.6971 7.3599C12.4044 7.6529 11.9295 7.65306 11.6365 7.36027L8.91435 4.64004L8.91435 13.5C8.91435 13.9142 8.57856 14.25 8.16435 14.25C7.75013 14.25 7.41435 13.9142 7.41435 13.5L7.41435 4.64442L4.69679 7.36025C4.4038 7.65305 3.92893 7.6529 3.63613 7.35992C3.34333 7.06693 3.34348 6.59206 3.63646 6.29926L7.60141 2.33683Z"
                                                        fill="#039855" />
                                                </svg>
                                            </p>
                                        </div>

                                        <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

                                        <div>
                                            <p
                                                class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                                                Today
                                            </p>
                                            <p
                                                class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                                                $20K
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M7.60141 2.33683C7.73885 2.18084 7.9401 2.08243 8.16435 2.08243C8.16475 2.08243 8.16516 2.08243 8.16556 2.08243C8.35773 2.08219 8.54998 2.15535 8.69664 2.30191L12.6968 6.29924C12.9898 6.59203 12.9899 7.0669 12.6971 7.3599C12.4044 7.6529 11.9295 7.65306 11.6365 7.36027L8.91435 4.64004L8.91435 13.5C8.91435 13.9142 8.57856 14.25 8.16435 14.25C7.75013 14.25 7.41435 13.9142 7.41435 13.5L7.41435 4.64442L4.69679 7.36025C4.4038 7.65305 3.92893 7.6529 3.63613 7.35992C3.34333 7.06693 3.34348 6.59206 3.63646 6.29926L7.60141 2.33683Z"
                                                        fill="#039855" />
                                                </svg>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- ====== Chart Two End -->
                                <!-- Pending Approval Start -->
                                <div
                                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 mt-6">
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.2" stroke="currentColor" class="w-6 h-6">
                                            <!-- Dokumen -->
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7 3h7l5 5v11.5A2.5 2.5 0 0 1 16.5 22h-9A2.5 2.5 0 0 1 5 19.5v-14A2.5 2.5 0 0 1 7.5 3Z" />

                                            <!-- Sudut dokumen terlipat -->
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v5h5" />

                                            <!-- Teks garis -->
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.5 10h7M8.5 13h7M8.5 16h4" />

                                            <!-- Tanda centang -->
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.5 18.5l1.5 1.5 3.5-3.5" />
                                        </svg>
                                    </div>

                                    <div class="mt-5 flex items-end justify-between">
                                        <div>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Pending Approval</span>
                                            <h4 class="mt-2 text-xl font-bold text-gray-800 dark:text-white/90">
                                                {{ $pendingRequests }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- Panding Approval End -->
                            </div>

                        </div>
                    </div>
                </main>
                <!-- ===== Main Content End ===== -->
            </div>
            <!-- ===== Content Area End ===== -->
        </div>
        <!-- ===== Page Wrapper End ===== -->
    </body>
@endsection