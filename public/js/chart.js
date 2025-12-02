let chartInstance = null;

fetch("/admin/finance/monthly-summary")
    .then((res) => res.json())
    .then((data) => {
        const incomes = data.incomes.map(Number);
        const expenses = data.expenses.map(Number);

        const chartContainer = document.querySelector("#chartIncExpense");

        if (chartInstance !== null) {
            chartInstance.destroy();
            chartInstance = null;
        }

        const options = {
            series: [
                { name: "Incomes", data: incomes },
                { name: "Expenses", data: expenses },
            ],
            chart: {
                type: "bar",
                height: 250,
                toolbar: { show: false },
            },
            colors: ["#2196F3", "#E91E63"],
            xaxis: {
                categories: [
                    "Jan","Feb","Mar","Apr","May","Jun",
                    "Jul","Aug","Sep","Oct","Nov","Dec",
                ],
            },
            plotOptions: {
                bar: { columnWidth: "40%", borderRadius: 5 },
            },
            dataLabels: { enabled: false },
        };

        chartInstance = new ApexCharts(chartContainer, options);
        chartInstance.render().then(() => {

            // 🔥 FIX WAJIB: perbaiki chart saat layar resize
            window.addEventListener("resize", () => {
                if (chartInstance) {
                    chartInstance.resize();
                }
            });

        });
    });
