document.addEventListener('DOMContentLoaded', function(){
    function createRadarChart(canvasId, labels, data, label = "Data") {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.2)', // blue-500 semi-transparent
                    borderColor: 'rgba(59, 130, 246, 1)',
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
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
                            color: '#4B5563', // gray-700
                        },
                        pointLabels: {
                            color: '#374151', // gray-800
                            font: { size: 14 }
                        }
                    }
                },
                plugins: {
                    legend: { display: true }
                }
            }
        });
    }

    // Example usage:
    createRadarChart("radarChart",
        ["Pills", "IUD", "Condom", "Implant", "Injection", "Natural"],
        [12, 8, 15, 5, 10, 6],
        "Number of Users"
    );
});