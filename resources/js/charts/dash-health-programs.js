console.log('🔄 dash-health-programs.js executing...');

Chart.defaults.font.family = 'Poppins, sans-serif';
Chart.defaults.font.size = 14; 
Chart.defaults.color = '#566A7F';

// Chart 1: Residents Line Chart
const ctx = document.getElementById('residentsLineChart');
if (!ctx) {
    console.error('❌ Canvas #residentsLineChart not found');
} else {
    console.log('✅ Creating residents line chart...');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Nutrition Program',
                    data: [120, 150, 180, 170, 200, 230],
                    borderColor: '#279EFF',
                    backgroundColor: 'rgba(39,158,255,0.1)',
                    tension: 0
                },
                {
                    label: 'Vaccination',
                    data: [90, 110, 160, 140, 180, 210],
                    borderColor: '#328E6E',
                    backgroundColor: 'rgba(50,142,110,0.1)',
                    tension: 0
                },
                {
                    label: 'Maternal Care',
                    data: [60, 80, 100, 120, 130, 140],
                    borderColor: '#F0BB78',
                    backgroundColor: 'rgba(240,187,120,0.1)',
                    tension: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#566A7F'
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
    console.log('✅ Deworming chart created');
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
    
    const medicineStocks = [
        { name: 'Medicine 1', stock: 21 },
        { name: 'Medicine 2', stock: 50 },
        { name: 'Medicine 3', stock: 101 },
        { name: 'Medicine 4', stock: 201 },
        { name: 'A Very Long Medicine Name That Needs Truncating', stock: 201 },
        { name: 'Medicine 6', stock: 201 },
        { name: 'Medicine 7', stock: 201 },
    ];

    const maxStock = Math.max(...medicineStocks.map(item => item.stock));
    const barColorClass = 'bg-mainblue';

    medicineStocks.forEach(medicine => {
        const widthPercentage = maxStock > 0 ? (medicine.stock / maxStock) * 100 : 0;

        const medicineItemDiv = document.createElement('div');
        medicineItemDiv.className = 'flex items-center';

        const nameDiv = document.createElement('div');
        nameDiv.className = 'w-1/4 text-sm pr-2 overflow-hidden text-ellipsis whitespace-nowrap';
        nameDiv.textContent = medicine.name;
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

console.log('🎉 dash-health-programs.js execution completed!');