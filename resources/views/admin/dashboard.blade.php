@extends('layouts.main')

@section('title', 'Dashboard Admin | WokaCash')

@section('content')
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
                                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.0821 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955ZM19.9248 19.8987H16.3901C16.7014 19.4736 16.9159 18.969 16.9827 18.3987H19.9248C20.1341 18.3987 20.2991 18.3141 20.3936 18.2112C20.4796 18.1175 20.5169 18.0034 20.4837 17.861C20.2969 17.0607 19.913 16.088 19.1382 15.3208C18.4047 14.5945 17.261 13.9921 15.4231 13.9566C15.2232 13.6945 14.9995 13.437 14.7491 13.1891C14.5144 12.9566 14.262 12.7384 13.9916 12.5362C14.3853 12.4831 14.8044 12.4549 15.2503 12.4549C17.5447 12.4549 19.1291 13.2008 20.1936 14.2549C21.2395 15.2906 21.7206 16.5607 21.9444 17.5202C22.2657 18.8971 21.107 19.8987 19.9248 19.8987Z"
                                                fill="" />
                                        </svg>
                                    </div>

                                    <div class="mt-5 flex items-end justify-between">
                                        <div>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Staff</span>
                                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                                {{ $staff }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- Metric Item End -->

                                <!-- Metric Item Start -->
                                <div
                                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M3 21V3h8v18H3Zm10 0V8h8v13h-8ZM6 6h2V5H6v1Zm0 3h2V8H6v1Zm0 3h2v-1H6v1Zm0 3h2v-1H6v1Zm10-6h2V9h-2v1Zm0 3h2v-1h-2v1Zm0 3h2v-1h-2v1Z"/>
                                        </svg>
                                    </div>

                                    <div class="mt-5 flex items-end justify-between">
                                        <div>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Branch</span>
                                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                                {{ $branchCount }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- Metric Item End -->
                            </div>
                            <!-- Metric Group One -->

                            <!-- ====== Chart One Start -->
                            <div
                                class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                        Monthly Sales
                                    </h3>

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
                                            class="absolute right-0 z-40 w-40 p-2 space-y-1 bg-white border border-gray-200 top-full rounded-2xl shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark">
                                            <button
                                                class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                                View More
                                            </button>
                                            <button
                                                class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full overflow-x-auto custom-scrollbar">
                                    <div class="inline-block">
                                        <canvas id="chartIncExpense" height="220"></canvas>
                                    </div>
                                </div>

                            </div>
                            <!-- ====== Chart One End -->
                        </div>
                        <div class="col-span-12 xl:col-span-5">
                            <!-- ====== Chart Two Start -->
                            <div
                                class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/[0.03]">
                                <div
                                    class="shadow-default rounded-2xl bg-white px-5 pb-11 pt-5 dark:bg-gray-900 sm:px-6 sm:pt-6">
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
                                    <div class="relative">
                                        <div class="relative w-full flex justify-center items-center">
                                            <canvas id="percentage" style="height: 180px" width="200" height="100"
                                                data-percent="{{ $percent }}" class="relative z-0">
                                            </canvas>
                                            <div id="percentageText"
                                                class="absolute z-10 mt-10 text-2xl font-semibold text-gray-700">
                                                {{ $percent }}%
                                            </div>
                                        </div>

                                        <span
                                            class="absolute left-1/2 top-[85%] -translate-x-1/2 -translate-y-[85%]
                                            rounded-full px-3 py-1 text-xs font-medium
                                            {{ $growth >= 0
                                                ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
                                                : 'bg-danger-50 text-danger-600 dark:bg-danger-500/15 dark:text-danger-500' }}">
                                            {{ $growth >= 0 ? '+' . $growth : $growth }}%
                                        </span>

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
                                            Rp{{ number_format($target, 0, ',', '.') }}
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
                                            Rp{{ number_format($revenue, 0, ',', '.') }}
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
                                            Rp{{ number_format($today, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- ====== Chart Two End -->
                        </div>

                        <div class="col-span-12">
                            <!-- ====== Chart Three Start -->
                            <div
                                class="rounded-2xl border border-gray-200 px-5 pb-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
                                <div class="flex flex-col mb-6 sm:flex-row sm:justify-between">
                                    <div class="w-full">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                            Statistics
                                        </h3>
                                        <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                                            Target you’ve set for each month
                                        </p>
                                    </div>

                                    <div x-data="{ selected: 'overview', type: 'income' }" class="relative w-full">

                                        <!-- INCOME / EXPENSE CENTERED (ABSOLUTE) -->
                                        <div id="incomeExpenseBox" x-show="selected === 'overview'"
                                            x-transition.opacity.duration.250ms
                                            class="
                                                    inline-flex items-center gap-0.5 rounded-lg bg-gray-100 p-0.5 dark:bg-gray-900"
                                            style="pointer-events: auto; position: absolute; left: 60%">
                                            <button @click="type = 'income'; $dispatch('type-changed', { type })"
                                                :class="type === 'income'
                                                    ?
                                                    'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                                                    'text-gray-500 dark:text-gray-400'"
                                                class="px-3 py-2 font-medium rounded-md text-theme-sm">
                                                Income
                                            </button>

                                            <button @click="type = 'expense'; $dispatch('type-changed', { type })"
                                                :class="type === 'expense'
                                                    ?
                                                    'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                                                    'text-gray-500 dark:text-gray-400'"
                                                class="px-3 py-2 font-medium rounded-md text-theme-sm">
                                                Expense
                                            </button>
                                        </div>

                                        <!-- MENU -->
                                        <div
                                            class="inline-flex w-fit items-center gap-0.5 rounded-lg bg-gray-100 p-0.5 dark:bg-gray-900">

                                            <!-- Overview -->
                                            <button
                                                @click="
                                                selected = 'overview';
                                                $dispatch('chart-changed', { chart: 'overview' });
                                                "
                                                :class="selected === 'overview'
                                                    ?
                                                    'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                                                    'text-gray-500 dark:text-gray-400'"
                                                class="px-3 py-2 font-medium rounded-md text-theme-sm">
                                                Overview
                                            </button>

                                            <!-- Branches -->
                                            @foreach ($branchCharts as $id => $b)
                                                <button
                                                    @click="
                                                    selected = '{{ $id }}';
                                                    $dispatch('chart-changed', { chart: '{{ $id }}' });
                                                    "
                                                    :class="selected === '{{ $id }}'
                                                        ?
                                                        'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                                                        'text-gray-500 dark:text-gray-400'"
                                                    class="px-3 py-2 font-medium rounded-md text-theme-sm">
                                                    {{ Str::limit($b['name'], 3) }}
                                                </button>
                                            @endforeach

                                        </div>
                                    </div>

                                </div>
                                <div class="max-w-full overflow-x-auto custom-scrollbar">
                                    <canvas id="branchAreaChart" class="min-w-[700px] h-[350px] -ml-4 pl-2"></canvas>
                                </div>
                            </div>
                            <!-- ====== Chart Three End -->
                        </div>

                    </div>
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script>
        window.chartData = {
            months: @json($months),
            overview: {
                income: @json($overviewIncome),
                expense: @json($overviewExpense),
            },
            branches: @json($branchCharts)
        };
    </script>

    @vite('resources/js/app.js')
@endsection
