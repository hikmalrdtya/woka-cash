import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Legend,
    Tooltip,
} from "chart.js";

Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Legend,
    Tooltip
);

export const initChart = () => {
    const canvas = document.getElementById("chartIncExpense");
    if (!canvas) return;

    // PAKSA canvas lebih lebar → biar bisa overflow-x
    canvas.width = 1500;

    let chartInstance = null;

    const renderChart = (incomes, expenses) => {
        incomes = incomes.map((n) => Number(n) || 0);
        expenses = expenses.map((n) => Number(n) || 0);

        if (chartInstance) {
            chartInstance.data.datasets[0].data = incomes;
            chartInstance.data.datasets[1].data = expenses;
            chartInstance.update();
            return;
        }

        chartInstance = new Chart(canvas, {
            type: "bar",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [
                    {
                        label: "Total Income",
                        data: incomes, // hanya income total
                        backgroundColor: "#465fff",
                        borderRadius: 20,
                        borderSkipped: false,
                        barThickness: 14, // boleh dilebarkan
                    },
                ],
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        categoryPercentage: 0.5,
                        barPercentage: 0.7, // karena 1 bar, bisa lebih besar
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: "rgba(255,255,255,0.07)",
                            drawBorder: false,
                        },
                        ticks: { color: "#ccd2e3" },
                    },
                },
            },
        });
    };

    fetch("/admin/finance/monthly-summary")
        .then((res) => res.json())
        .then((data) => {
            renderChart(data.incomes || [], data.expenses || []);
        })
        .catch((err) => console.error("Fetch chart error:", err));
};
