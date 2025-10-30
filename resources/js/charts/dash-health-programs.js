const healthPrograms = window.enrolledResidents;
const medicines = window.medicines;

console.log(medicines);

Chart.defaults.font.family = 'Poppins, sans-serif';
Chart.defaults.font.size = 14; 
Chart.defaults.color = '#566A7F';

// Transform the data for Chart.js
// First, get all unique months across all programs
const allMonths = new Set();
healthPrograms.forEach(program => {
    program.monthly_data.forEach(month => {
        allMonths.add(month.month);
    });
});

// Convert to array and sort by date
const monthLabels = Array.from(allMonths).sort((a, b) => {
    return new Date(a) - new Date(b);
});

// Format labels to short form (e.g., "Jun 2025" -> "Jun")
const formattedLabels = monthLabels.map(month => {
    return month.split(' ')[0].substring(0, 3); // Get first 3 letters of month
});

// Define colors for each program
const colors = [
    { border: '#279EFF', background: 'rgba(39,158,255,0.1)' },    // Blue
    { border: '#328E6E', background: 'rgba(50,142,110,0.1)' },    // Green
    { border: '#F0BB78', background: 'rgba(240,187,120,0.1)' },   // Orange
];

// Create datasets from health programs
const datasets = healthPrograms.map((program, index) => {
    // Create a map of month -> count for this program
    const monthCountMap = {};
    program.monthly_data.forEach(month => {
        monthCountMap[month.month] = month.count;
    });
    
    // Build data array matching the month labels
    const data = monthLabels.map(month => monthCountMap[month] || 0);
    
    return {
        label: program.program_name,
        data: data,
        borderColor: colors[index % colors.length].border,
        backgroundColor: colors[index % colors.length].background,
        tension: 0
    };
});

// Chart 1: Residents Line Chart
const ctx = document.getElementById('residentsLineChart');
if (!ctx) {
    console.error('Canvas #residentsLineChart not found');
} else {
    console.log('Creating residents line chart...');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: formattedLabels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#566A7F',
                        stepSize: 1  // Use whole numbers for counts
                    }
                },
                x: {
                    ticks: {
                        color: '#566A7F'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#252F6C'
                    }
                }
            }
        }
    });
    
    console.log('✅ Residents line chart created');
}
// Chart 2: Residents Per Purok Chart
const residentsPerPurokChartCtx = document.getElementById('residentsPerPurokChart');
if (!residentsPerPurokChartCtx) {
    console.error('❌ Canvas #residentsPerPurokChart not found');
} else {
    console.log('✅ Creating residents per purok chart...');
    
    const residentsPerPurokData = {
        labels: ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4'],
        datasets: [{
            data: [50, 40, 5, 5],
            backgroundColor: [
                '#fd6e69ff',
                '#F0BB78',
                '#4DA1A9',
                '#B7B1F2'
            ],
            hoverOffset: 4,
            borderRadius: 8 
        }]
    };

    const residentsPerPurokConfig = {
        type: 'doughnut',
        data: residentsPerPurokData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
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

    new Chart(residentsPerPurokChartCtx.getContext('2d'), residentsPerPurokConfig);
    console.log('✅ Residents per purok chart created');
}

// Chart 3: Deworming Chart
const dewormingChartCtx = document.getElementById('dewormingChart');
if (!dewormingChartCtx) {
    console.error('❌ Canvas #dewormingChart not found');
} else {
    console.log('✅ Creating deworming chart...');
    
    const dewormingData = {
        labels: ['Dewormed', 'Not Dewormed'],
        datasets: [{
            data: [60, 40],
            backgroundColor: [
                '#fd6e69ff',
                '#F0BB78',
            ],
            hoverOffset: 4,
            borderRadius: 8 
        }]
    };

    const dewormingConfig = {
        type: 'doughnut',
        data: dewormingData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
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

    new Chart(dewormingChartCtx.getContext('2d'), dewormingConfig);
}

// Chart 4: PhilPEN Metrics Chart
const philpenMetricsChartCtx = document.getElementById('philpenMetricsChart');
if (!philpenMetricsChartCtx) {
    console.error('❌ Canvas #philpenMetricsChart not found');
} else {
    console.log('✅ Creating PhilPEN metrics chart...');
    
    const philpenMetricsData = {
        labels: ['Completed', 'Missing'],
        datasets: [{
            data: [90, 10],
            backgroundColor: [
                '#279EFF',
                '#697A8D'
            ],
            hoverOffset: 4,
            borderRadius: 8 
        }]
    };

    const philpenMetricsConfig = {
        type: 'doughnut',
        data: philpenMetricsData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
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

    new Chart(philpenMetricsChartCtx.getContext('2d'), philpenMetricsConfig);
    console.log('✅ PhilPEN metrics chart created');
}

// Medicine Stocks Chart (Custom HTML-based chart)
const container = document.getElementById('medicineStocksChartContainer');
if (!container) {
    console.error('❌ Container #medicineStocksChartContainer not found');
} else {
    console.log('✅ Creating medicine stocks chart...');
    
    // Transform the medicines data
    const medicineStocks = medicines.map(medicine => ({
        name: medicine.medicine_name,
        stock: medicine.total_stock || 0
    }));

    const maxStock = Math.max(...medicineStocks.map(item => item.stock));
    const barColorClass = 'bg-mainblue';

    medicineStocks.forEach(medicine => {
        const widthPercentage = maxStock > 0 ? (medicine.stock / maxStock) * 100 : 0;

        const medicineItemDiv = document.createElement('div');
        medicineItemDiv.className = 'flex items-center';

        const nameDiv = document.createElement('div');
        nameDiv.className = 'w-1/4 text-sm pr-2 overflow-hidden text-ellipsis whitespace-nowrap';
        nameDiv.textContent = medicine.name;
        nameDiv.title = medicine.name; // Add tooltip for full name on hover
        medicineItemDiv.appendChild(nameDiv);

        const barWrapperDiv = document.createElement('div');
        barWrapperDiv.className = 'relative flex-grow h-7 rounded';

        const barDiv = document.createElement('div');
        barDiv.className = `${barColorClass} h-full rounded`;
        barDiv.style.width = `${widthPercentage}%`;

        const stockNumberSpan = document.createElement('span');
        stockNumberSpan.textContent = medicine.stock;
        stockNumberSpan.className = 'absolute inset-y-0 left-2 flex items-center text-white text-sm font-medium';

        barWrapperDiv.appendChild(barDiv);
        barWrapperDiv.appendChild(stockNumberSpan);

        medicineItemDiv.appendChild(barWrapperDiv);
        container.appendChild(medicineItemDiv);
    });
    
    console.log('✅ Medicine stocks chart created');
}
