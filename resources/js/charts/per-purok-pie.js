const residentsPerPurok = window.residentsPerPurok || {};
const householdsPerPurok = window.householdsPerPurok || {};

// Auto-detect purok labels from backend
const puroks = Object.keys(residentsPerPurok).length
    ? Object.keys(residentsPerPurok)
    : Array.from({ length: 10 }, (_, i) => `Purok ${i + 1}`);

// Extract actual values
const residentData = Object.values(residentsPerPurok);
const householdData = Object.values(householdsPerPurok);

const createDonutChart = (ctxId, label, legendId, dataValues) => {
    const ctx = document.getElementById(ctxId).getContext('2d');

    const chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: puroks,
            datasets: [{
                label,
                data: dataValues,
                backgroundColor: [
                    '#fa849dff', '#67b7edff', '#fce19cff', '#b2e27cff', '#a88cefff',
                    '#9f5fabff', '#79a9f0ff', '#e46d95ff', '#6ecf71ff', '#e67ff8ff'
                ],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverBorderWidth: 3,
                hoverOffset: 4,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#fff',
                    borderWidth: 1,
                    callbacks: {
                        label: function (context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '45%'
        }
    });

    // Custom legend
    const legendContainer = document.getElementById(legendId);
    const legendHTML = puroks.map((purok, index) => {
        const color = chart.data.datasets[0].backgroundColor[index];
        const value = dataValues[index] || 0;
        return `
            <div class="flex items-center gap-3 py-1">
                <div class="w-10 h-3 rounded-full" style="background-color: ${color}"></div>
                <div class="gap-6 flex items-center">
                    <span class="text-gray-700">${purok}:</span>
                    <span class="font-semibold">${value}</span>
                </div>
            </div>
        `;
    }).join('');

    legendContainer.innerHTML = legendHTML;

    return chart;
};

// Initialize charts using backend data
createDonutChart('residentsPerPurokChart', 'Residents', 'residentsLegend', residentData);
createDonutChart('householdsPerPurokChart', 'Households', 'householdsLegend', householdData);
