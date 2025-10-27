
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

// Extract family planning methods data from window
const fpMethods = window.familyPlanningMethods || {};

// Convert the object to arrays for the chart
const methodLabels = [];
const methodCounts = [];

// Define a mapping for better display names
const methodNameMap = {
    'btl': 'BTL',
    'nsp': 'NSP',
    'pills': 'Pills',
    'iud': 'IUD',
    'condom_male': 'Male Condom',
    'condom_female': 'Female Condom',
    'condom': 'Condom',
    'implant': 'Implant',
    'injection': 'Injectable',
    'natural': 'Natural',
    'lam': 'LAM',
    'sdm': 'SDM',
    'bbt': 'BBT',
    'stm': 'STM',
    'coc': 'COC',
    'pop': 'POP'
};

// Loop through the methods and build arrays
for (const [method, count] of Object.entries(fpMethods)) {
    // Use mapped name or capitalize the method name
    const displayName = methodNameMap[method] || method.charAt(0).toUpperCase() + method.slice(1).replace('_', ' ');
    methodLabels.push(displayName);
    methodCounts.push(count);
}

// If no data, show empty chart with placeholder
if (methodLabels.length === 0) {
    methodLabels.push('No Data');
    methodCounts.push(0);
}

// Chart 1 – Family Planning Methods
createRadarChart(
    "radarChart",
    methodLabels,
    methodCounts,
    "Number of Users",
    "wood_or"
);

// Chart 2 – Child Nutrition (children under 2 years)
createRadarChart("childNutrition",
    ["Normal", "Underweight", "Severely Underweight", "Overweight", "Obese"],
    [
        window.normalWeight || 0,
        window.underweight || 0,
        window.severelyUnderweight || 0,
        window.overweight || 0,
        window.obese || 0
    ],
    "Child Weight Classification",
    "green"
);


