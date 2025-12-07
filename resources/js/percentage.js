import {
    Chart,
    DoughnutController,
    ArcElement,
    Tooltip
} from "chart.js";

Chart.register(DoughnutController, ArcElement, Tooltip);

export const initChartTwo = () => {
    const el = document.getElementById("percentage");
    const textEl = document.getElementById("percentageText");
    if (!el) return;

    const percent = parseFloat(el.dataset.percent);
    const remaining = 100 - percent;

    new Chart(el, {
        type: "doughnut",
        data: {
            datasets: [
                {
                    data: [percent, remaining],
                    backgroundColor: ["#4D7CFE", "#E5E7EB"],
                    borderWidth: 0,
                },
            ],
        },
        options: {
            cutout: "75%",
            rotation: -90,
            circumference: 180,
            plugins: {
                tooltip: { enabled: false },
            },
        },
    });

    // update teks supaya dinamis
    if (textEl) {
        textEl.innerHTML = `${Math.round(percent)}%`;
    }
};
