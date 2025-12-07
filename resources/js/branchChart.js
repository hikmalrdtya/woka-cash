import {
    Chart,
    LineController,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Filler,
    Tooltip,
    Legend,
} from "chart.js";

Chart.register(
    LineController,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Filler,
    Tooltip,
    Legend
);

let chartInstance = null;

export function initBranchAreaChart() {
    const canvas = document.getElementById("branchAreaChart");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");

    // Data dari Blade
    const { months, branches } = window.chartData;

    const colors = [
        "#3b82f6",
        "#ef4444",
        "#22c55e",
        "#a855f7",
        "#f59e0b",
        "#14b8a6",
        "#8b5cf6",
        "#ec4899",
    ];

    function renderChart(type = "income", selected = "overview") {
        if (chartInstance) chartInstance.destroy();

        // ========== OVERVIEW ==========
        if (selected === "overview") {
            const datasets = [];
            let i = 0;

            Object.values(branches).forEach((b) => {
                const data = type === "income" ? b.income : b.expense;

                datasets.push({
                    label: b.name,
                    data,
                    fill: false,
                    borderColor:
                        type === "income"
                            ? colors[i % colors.length]
                            : "#dc2626",
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 0,
                });

                i++;
            });

            chartInstance = new Chart(ctx, {
                type: "line",
                data: {
                    labels: months,
                    datasets,
                },
            });

            return;
        }

        // ========== BRANCH DETAIL ==========
        if (branches[selected]) {
            const b = branches[selected];

            chartInstance = new Chart(ctx, {
                type: "line",
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: `${b.name} — Income`,
                            data: b.income,
                            borderColor: "#4C6FFF",
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false,
                            pointRadius: 0,
                        },
                        {
                            label: `${b.name} — Expense`,
                            data: b.expense,
                            borderColor: "#FF4C4C",
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false,
                            pointRadius: 0,
                        },
                    ],
                },
            });
        }
    }

    // Default load
    let selectedChart = "overview";
    let selectedType = "income";

    renderChart(selectedType, selectedChart);

    // Sinkron dengan Alpine (tidak override)
    window.addEventListener("chart-changed", (e) => {
        selectedChart = e.detail.chart;
        renderChart(selectedType, selectedChart);
    });

    window.addEventListener("type-changed", (e) => {
        selectedType = e.detail.type;
        renderChart(selectedType, selectedChart);
    });
}
