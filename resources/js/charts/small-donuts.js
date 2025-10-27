
const totalFemales = window.femaleData.reduce((sum, count) => sum + count, 0);
// Women of Reproductive Age (2 groups)
const wraCount = window.wra || 0;
const nonWRA = totalFemales - wraCount;


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
                                label += context.parsed;
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

function getIndigentData() {
    const totalFamilies = window.families; // total number of families
    const indigentData = window.familiesIndigentPerPurok;

    // Sum all indigent families from each purok
    const totalIndigentFamilies = Object.values(indigentData).reduce((sum, count) => sum + count, 0);

    // Non-indigent = total - indigent
    const totalNonIndigentFamilies = totalFamilies - totalIndigentFamilies;

    return {
        totalIndigentFamilies,
        totalNonIndigentFamilies
    };
}

function getSexDistribution() {
    const maleData = window.maleData || [];
    const femaleData = window.femaleData || [];

    // Sum all male and female counts across age groups
    const totalMales = maleData.reduce((sum, count) => sum + (Number(count) || 0), 0);
    const totalFemales = femaleData.reduce((sum, count) => sum + (Number(count) || 0), 0);

    const malePerPurok = window.malesPerPurok;
    const femalePerPurok = window.femalesPerPurok;

    return { totalMales, totalFemales };
}

function getPwd() {
    const pwdPerPurokData = window.pwdsPerPurok || {};
    const nonPwdPerPurokData = window.nonPwdsPerPurok || {};

    // Get an array of the values from the object and sum them up
    const totalPwd = Object.values(pwdPerPurokData).reduce((sum, count) => sum + count, 0);
    const totalNonPwd = Object.values(nonPwdPerPurokData).reduce((sum, count) => sum + count, 0);
    

    return {totalPwd, totalNonPwd};
}


// Example usage
renderDoughnutChart({
    elementId: 'genderChart',
    labels: ['Male', 'Female'],
    data: [getSexDistribution().totalMales, getSexDistribution().totalFemales],
    colors: ['#4A90E2', '#F78FB3']
});

renderDoughnutChart({
    elementId: 'pwdChart',
    labels: ['PWDs', 'Non-PWD'],
    data: [getPwd().totalPwd, getPwd().totalNonPwd],
    colors: ['#fd6e69ff', '#F0BB78']
});

renderDoughnutChart({
    elementId: 'indigentChart',
    labels: ['Indigent', 'Non-Idigent'],
    data: [getIndigentData().totalIndigentFamilies, getIndigentData().totalNonIndigentFamilies],
    colors: ['#4DFFBE', '#9ECAD6']
});

renderDoughnutChart({
    elementId: 'pregnantChart',
    labels: ['Teenage Pregnancy', 'Primis', 'Multi-Para', 'Others'],
    data: [
        window.teenPregnancies || 0,
        window.primis || 0,
        window.multiPara || 0,
        window.pregnancyOthers || 0
    ],
    colors: ['#FFA07A', '#FFB347', '#FFD700', '#90EE90']
});

renderDoughnutChart({
    elementId: 'reproductiveChart',
    labels: ['WRA', 'Non-WRA'],
    data: [wraCount, nonWRA],
    colors: ['#9370DB', '#D8BFD8']
});

// Lactating Mothers (2 groups)
const lactatingCount = window.totalLactating || 0;
const nonLactating = wraCount - lactatingCount;

renderDoughnutChart({
    elementId: 'lactatingChart',
    labels: ['Lactating', 'Non-Lactating'],
    data: [lactatingCount, nonLactating],
    colors: ['#FF69B4', '#E0E0E0']
});


renderDoughnutChart({
    elementId: 'childImmunizationChart',
    labels: ['FIC', 'CIC'],  // Changed MIC to CIC (Completely Immunized Child)
    data: [
        window.ficCount || 0,
        window.cicCount || 0
    ],
    colors: ['#187756ff', '#72bb9dff']  // green and soft green
});
// Sanitary Toilets
renderDoughnutChart({
    elementId: 'sanitaryHousehold',
    labels: ["With Sanitary Toilets", "With Unsanitary Toilets", "Without Toilets"],
    data: [
        window.sanitaryData.with_sanitary_toilet,
        window.sanitaryData.with_unsanitary_toilet,
        window.sanitaryData.without_toilet
    ],
    colors: ['#9370DB', '#D8BFD8', '#93b1dcff']
});

// Waste Disposal
renderDoughnutChart({
    elementId: 'waste-disposal',
    labels: Object.keys(window.wasteDisposal),
    data: Object.values(window.wasteDisposal),
    colors: ['#9370DB', '#3CB371', '#F4A460', '#4682B4', '#FF6347'] // add more if needed
});

// Water Source
renderDoughnutChart({
    elementId: 'water-source',
    labels: Object.keys(window.waterSource),
    data: Object.values(window.waterSource),
    colors: ['#9370DB', '#3CB371', '#F4A460', '#4682B4'] // match number of labels
});
