document.addEventListener('DOMContentLoaded', function () {
    function renderDoughnutChart({ elementId, labels, data, colors }) {
        const canvas = document.getElementById(elementId);
        if (!canvas) {
            console.warn(`Canvas with id "${elementId}" not found.`);
            return;
        }

        const ctx = canvas.getContext('2d');

        const chartData = {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                hoverOffset: 4,
                borderRadius: 8
            }]
        };

        const chartConfig = {
            type: 'doughnut',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + '%';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        };

        new Chart(ctx, chartConfig);
    }

    // Example usage
    renderDoughnutChart({
        elementId: 'genderChart',
        labels: ['Male', 'Female'],
        data: [45, 55],
        colors: ['#4A90E2', '#F78FB3']
    });

    renderDoughnutChart({
        elementId: 'dewormingChart',
        labels: ['Dewormed', 'Not Dewormed'],
        data: [60, 40],
        colors: ['#fd6e69ff', '#F0BB78']
    });
});
