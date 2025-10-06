
// Execute immediately - no DOMContentLoaded wrapper needed
const ctx = document.getElementById('ageGroupChart');

if (!ctx) {
    console.error('Canvas #ageGroupChart not found');
} else {
    console.log('Canvas found, creating age group chart...');
    
    const ctx2d = ctx.getContext('2d');
    
    // Generate 18 example age groups
    const ageGroups = window.ageGroups;

    // Sample data for male and female counts for 18 age groups
    // **Replace this with your actual data**
    const maleData = window.maleData;
    const femaleData = window.femaleData;

   
    const stackedBarChart = new Chart(ctx2d, {
        type: 'bar',
        data: {
            labels: ageGroups,
            datasets: [
                {
                    label: 'Male',
                    data: maleData,
                    backgroundColor: 'deepskyblue',
                    borderColor: 'deepskyblue',
                   
                    borderWidth: 1
                },
                {
                    label: 'Female',
                    data: femaleData,
                    backgroundColor: 'lightcoral',
                    borderColor: 'lightcoral',
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
    
}