@extends('layouts.main')

@section('title', 'Dashboard Staff | WokaCash')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Metric Cards --}}
        <div class="flex gap-6 mt-6 justify-between">
            <!-- Total Income -->
            <div class="flex-1 flex items-center gap-4 p-5 bg-white dark:bg-gray-800 rounded-xl shadow">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700">
                    <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Income (Month)</p>
                    <h3 class="mt-1 font-bold text-gray-800 dark:text-white">Rp
                        {{ number_format($totalIncome, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- Total Expense -->
            <div class="flex-1 flex items-center gap-4 p-5 bg-white dark:bg-gray-800 rounded-xl shadow">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700">
                    <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M3 21V3h8v18H3Zm10 0V8h8v13h-8ZM6 6h2V5H6v1Zm0 3h2V8H6v1Zm0 3h2v-1H6v1Zm0 3h2v-1H6v1Zm10-6h2V9h-2v1Zm0 3h2v-1h-2v1Zm0 3h2v-1h-2v1Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Expense (Month)</p>
                    <h3 class="mt-1 font-bold text-gray-800 dark:text-white">Rp
                        {{ number_format($totalExpense, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- Waiting Approval -->
            <div class="flex-1 flex items-center gap-4 p-5 bg-white dark:bg-gray-800 rounded-xl shadow">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700">
                    <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24">
                        <path
                            d="M3 21V3h8v18H3Zm10 0V8h8v13h-8ZM6 6h2V5H6v1Zm0 3h2V8H6v1Zm0 3h2v-1H6v1Zm0 3h2v-1H6v1Zm10-6h2V9h-2v1Zm0 3h2v-1h-2v1Zm0 3h2v-1h-2v1Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Waiting Approval</p>
                    <h3 class="mt-1 font-bold text-gray-800 dark:text-white">{{ $pendingRequests }}</h3>
                </div>
            </div>
        </div>

        {{-- Filter + Charts --}}
        <div class="mt-8 space-y-8">

            {{-- Filter --}}
            <div class="flex items-center gap-4">
                <select id="chartFilter" class="px-3 py-2 rounded-lg border dark:bg-gray-700 dark:text-white">
                    <option value="daily">Harian</option>
                    <option value="monthly" selected>Bulanan</option>
                    <option value="yearly">Tahunan</option>
                </select>

                <span class="text-gray-600 dark:text-gray-300 text-sm">
                    Filter data transaksi
                </span>
            </div>

            {{-- Income Chart --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Income Chart</h3>
                <canvas id="incomeChart" height="120"></canvas>
            </div>

            {{-- Expense Chart --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Expense Chart</h3>
                <canvas id="expenseChart" height="120"></canvas>
            </div>

        </div>


        {{-- Latest Income & Expense --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            {{-- Latest Income --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Latest Income</h3>

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
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="py-3 px-2">{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                                <td class="py-3 px-2">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                                <td class="py-3 px-2">
                                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">
                                        {{ $row->project_id != null ? 'Project' : 'Other' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Latest Expense --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Latest Expense</h3>

                <table class="w-full text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="py-3 px-2 text-left">Date</th>
                            <th class="py-3 px-2 text-left">Amount</th>
                            <th class="py-3 px-2 text-left">Category</th>
                            <th class="py-3 px-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestExpense as $row)
                                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                            <td class="py-3 px-2">{{ \Carbon\Carbon::parse($row->expense_date)->format('d M Y') }}</td>
                                            <td class="py-3 px-2">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                                            <td class="py-3 px-2">{{ ucfirst($row->category) }}</td>
                                            <td class="py-3 px-2">
                                                <span class="px-2 py-1 text-xs rounded-full
                                                                                                                                                                    {{ $row->status == 'pending' ? 'bg-yellow-100 text-yellow-700' :
                            ($row->status == 'approved' ? 'bg-green-100 text-green-700' :
                                'bg-red-100 text-red-700') }}">
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        let incomeChart, expenseChart;

        function createGradient(ctx, color1, color2) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 250);
            gradient.addColorStop(0, color1);
            gradient.addColorStop(1, color2);
            return gradient;
        }

        function initCharts(labels, incomeData, expenseData) {
            const incomeCtx = document.getElementById('incomeChart').getContext('2d');
            const expenseCtx = document.getElementById('expenseChart').getContext('2d');

            const gradientBlue = createGradient(incomeCtx, '#3b82f6', 'rgba(59,130,246,0.1)');
            const gradientRed = createGradient(expenseCtx, '#ef4444', 'rgba(239,68,68,0.1)');

            incomeChart = new Chart(incomeCtx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Income',
                        data: incomeData,
                        borderColor: '#3b82f6',
                        backgroundColor: gradientBlue,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, animation: { duration: 800 } }
            });

            expenseChart = new Chart(expenseCtx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Expense',
                        data: expenseData,
                        borderColor: '#ef4444',
                        backgroundColor: gradientRed,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, animation: { duration: 800 } }
            });
        }

        async function loadInitialChart() {
            const res = await axios.get('/api/chart-data?filter=monthly');
            initCharts(res.data.labels, res.data.incomes, res.data.expenses);
        }

        async function loadChartData(filter = 'monthly') {
            const res = await axios.get(`/api/chart-data?filter=${filter}`);

            incomeChart.data.labels = res.data.labels;
            incomeChart.data.datasets[0].data = res.data.incomes;
            incomeChart.update();

            expenseChart.data.labels = res.data.labels;
            expenseChart.data.datasets[0].data = res.data.expenses;
            expenseChart.update();
        }

        document.getElementById('chartFilter').addEventListener('change', function () {
            loadChartData(this.value);
        });

        loadInitialChart();
    </script>


@endsection