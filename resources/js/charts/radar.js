document.addEventListener('DOMContentLoaded', function () {
    function createRadarChart(canvasId, labels, data, label = "Data", color = 'blue') {
        const ctx = document.getElementById(canvasId).getContext('2d');

        const colorMap = {
            blue: {
                bg: 'rgba(59, 130, 246, 0.2)',
                border: 'rgba(59, 130, 246, 1)',
                point: 'rgba(59, 130, 246, 1)'
            },
            indigo: {
                bg: 'rgba(99, 102, 241, 0.2)',
                border: 'rgba(99, 102, 241, 1)',
                point: 'rgba(99, 102, 241, 1)'
            },
            rose: {
                bg: 'rgba(244, 114, 182, 0.2)',
                border: 'rgba(244, 114, 182, 1)',
                point: 'rgba(244, 114, 182, 1)'
            },
            green: {
                bg: 'rgba(50, 142, 110, 0.15)',  // #328E6E soft background
                border: 'rgba(50, 142, 110, 1)',
                point: 'rgba(50, 142, 110, 1)'
            },
            wood_or: {
                bg: 'rgba(255, 166, 115, 0.15)',  // soft #FFA673
                border: 'rgba(255, 166, 115, 1)',
                point: 'rgba(255, 166, 115, 1)'
            }
        };

        const selected = colorMap[color] || colorMap.blue;

        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: selected.bg,
                    borderColor: selected.border,
                    pointBackgroundColor: selected.point,
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        angleLines: { display: true },
                        suggestedMin: 0,
                        suggestedMax: Math.max(...data),
                        ticks: {
                            stepSize: 1,
                            backdropColor: 'transparent',
                            color: '#4B5563',
                        },
                        pointLabels: {
                            color: '#374151',
                            font: { size: 12 }
                        }
                    }
                },
                plugins: {
                    legend: { display: true }
                }
            }
        });
    }

    // Chart 1 – Family Planning (wood_or tone)
    createRadarChart("radarChart",
        ["Pills", "IUD", "Condom", "Implant", "Injection", "Natural"],
        [12, 8, 15, 5, 10, 6],
        "Number of Users",
        "wood_or"
    );

    // Chart 2 – Child Nutrition (soft green tone)
    createRadarChart("childNutrition",
        ["Pills", "IUD", "Condom", "Implant", "Injection", "Natural"],
        [12, 8, 15, 5, 10, 6],
        "Number of Users",
        "green"
    );
});
