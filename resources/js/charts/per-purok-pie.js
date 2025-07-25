
    const puroks = Array.from({ length: 10 }, (_, i) => `Purok ${i + 1}`);
    const generateData = () => Array.from({ length: 10 }, () => Math.floor(Math.random() * 100 + 10));

        const createDonutChart = (ctxId, label, legendId) => {
            const ctx = document.getElementById(ctxId).getContext('2d');
            const data = generateData();
            
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: puroks,
                    datasets: [{
                        label,
                        data: data,
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
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#fff',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.parsed} (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: {
                            display: false
                        }
                    },
                    cutout: '45%'
                }
            });

    // Create custom legend
    const legendContainer = document.getElementById(legendId);
        const legendHTML = puroks.map((purok, index) => {
            const color = chart.data.datasets[0].backgroundColor[index];
            const value = data[index];
            return `
                <div class="flex items-center gap-3 py-1">
                    <div class="w-10 h-3 rounded-full" style="background-color: ${color}"></div>
                    <div class="gap-6 flex items-center">
                        <span class="text-gray-700 ">${purok}: </span>
                        <span class="font-semibold">${value}</span>
                    </div>
                </div>
            `;
        }).join('');
            
        legendContainer.innerHTML = legendHTML;
            
        return chart;
    };

    // Initialize charts after DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        createDonutChart('residentsPerPurokChart', 'Residents', 'residentsLegend');
        createDonutChart('householdsPerPurokChart', 'Households', 'householdsLegend');
        createDonutChart('familiesPerPurokChart', 'Families');
    });
