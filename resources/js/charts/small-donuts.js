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
        elementId: 'pwdChart',
        labels: ['PWDs', 'Non-PWD'],
        data: [60, 40],
        colors: ['#fd6e69ff', '#F0BB78']
    });

    renderDoughnutChart({
        elementId: 'indigentChart',
        labels: ['Indigent', 'Non-Idigent'],
        data: [60, 40],
        colors: ['#4DFFBE', '#9ECAD6' ]
    });

    // Pregnant Women (4 groups)
    renderDoughnutChart({
        elementId: 'pregnantChart',
        labels: ['Teenage Pregnancy', 'Primis', 'Multi-Para', 'Others'],
        data: [25, 30, 20, 10],
        colors: ['#FFA07A', '#FFB347', '#FFD700', '#90EE90']
    });

    // Lactating Mothers (2 groups)
    renderDoughnutChart({
        elementId: 'lactatingChart',
        labels: ['Lactating', 'Non-Lactating'],
        data: [70, 30],
        colors: ['#FF69B4', '#E0E0E0']
    });

    // Women of Reproductive Age (2 groups)
    renderDoughnutChart({
        elementId: 'reproductiveChart',
        labels: ['WRA', 'Non-WRA'],
        data: [80, 20],
        colors: ['#9370DB', '#D8BFD8']
    });

   renderDoughnutChart({
        elementId: 'famPlan',
        labels: ['Enrolled', 'Non-Enrolled'],
        data: [80, 20],
        colors: ['#FFA673', '#FFE0CC']  // Wood Orange + light
    });

    renderDoughnutChart({
        elementId: 'childWeight',
        labels: ['Weighted', 'Not Weighted'],
        data: [80, 20],
        colors: ['#328E6E', '#B9DBCD']  // Green + light
    });

    renderDoughnutChart({
        elementId: 'childImmunizationChart',
        labels: ['FIC', 'MIC'],
        data: [55, 18],
        colors: ['#187756ff', '#72bb9dff']  // green and soft green
    });
    renderDoughnutChart({
        elementId: 'sanitaryHousehold',
        labels: ["With Sanitary Toilets", "With Unsanitary Toilets", "Without Toilets"],
        data: [12, 8, 15],
        colors: ['#9370DB', '#D8BFD8', '#93b1dcff']
    });

    renderDoughnutChart({
        elementId: 'water-source',
        labels: ["Pumpwell", "Open Well", "Purified Water", "Tap Water"],
        data: [17, 21, 38, 38],
        colors: ['#9370DB', '#3CB371', '#F4A460', '#4682B4']
    });
});
