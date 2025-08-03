// charts/age-group-bar.js - FIXED VERSION
console.log('🔄 age-group-bar.js executing...');

// Execute immediately - no DOMContentLoaded wrapper needed
const ctx = document.getElementById('ageGroupChart');

if (!ctx) {
    console.error('❌ Canvas #ageGroupChart not found');
} else {
    console.log('✅ Canvas found, creating age group chart...');
    
    const ctx2d = ctx.getContext('2d');
    
    // Generate 18 example age groups
    const ageGroups = [
        '0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39',
        '40-44', '45-49', '50-54', '55-59', '60-64', '65-69', '70-74', '75-79',
        '80-84', '85+'
    ];

    // Sample data for male and female counts for 18 age groups
    // **Replace this with your actual data**
    const maleData = [
        50, 55, 60, 65, 70, 75, 80, 78, 72, 68, 62, 58, 52, 45, 38, 30, 25, 20
    ];
    const femaleData = [
        48, 58, 63, 68, 72, 78, 82, 80, 75, 70, 65, 60, 55, 48, 40, 32, 28, 22
    ];

    const stackedBarChart = new Chart(ctx2d, {
        type: 'bar',
        data: {
            labels: ageGroups,
            datasets: [
                {
                    label: 'Male',
                    data: maleData,
                    backgroundColor: 'lightcoral',
                    borderColor: 'lightcoral',
                    borderWidth: 1
                },
                {
                    label: 'Female',
                    data: femaleData,
                    backgroundColor: 'deepskyblue',
                    borderColor: 'deepskyblue',
                    borderWidth: 1
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Residents'
                    }
                }
            },
            plugins: {
                title: {
                    display: false,
                    text: 'Age Group Demographics'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        footer: (tooltipItems) => {
                            let sum = 0;
                            tooltipItems.forEach(function(tooltipItem) {
                                sum += tooltipItem.parsed.y;
                            });
                            return 'Total: ' + sum;
                        }
                    }
                }
            }
        }
    });
    
    console.log('✅ Age group chart created successfully');
}