document.addEventListener("DOMContentLoaded", function () {
    Chart.defaults.font.family = 'Poppins, sans-serif';
    Chart.defaults.font.size = 14; 
    Chart.defaults.color = '#566A7F';
    const ctx = document.getElementById('residentsLineChart');
    if (!ctx) return; // Ensure the canvas exists before proceeding

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

     // Data for Residents Per Purok Chart
    const residentsPerPurokData = {
        labels: ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4'],
        datasets: [{
            data: [50, 40, 5, 5], // Percentages from the image
            backgroundColor: [
                '#fd6e69ff', // Light Red/Coral for 50% (Purok 1)
                '#F0BB78', // Light Orange/Yellow for 40% (Purok 2)
                '#4DA1A9', // Light Green/Teal for 5% (Purok 3)
                '#B7B1F2'  // Light Purple for 5% (Purok 4)
            ],
            hoverOffset: 4,
            borderRadius: 8 
        }]
    };

    // Configuration for Residents Per Purok Chart
    const residentsPerPurokConfig = {
        type: 'doughnut', // Donut chart as it has a hole in the middle
        data: residentsPerPurokData,
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allows you to control height with CSS
            plugins: {
                legend: {
                    position: 'right', // Place legend on the right as in the image
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

    // Render Residents Per Purok Chart
    var residentsPerPurokChartCtx = document.getElementById('residentsPerPurokChart').getContext('2d');
    new Chart(residentsPerPurokChartCtx, residentsPerPurokConfig);

    // Data for Deworming Chart
    const dewormingData = {
        labels: ['Dewormed', 'Not Dewormed'],
        datasets: [{
            data: [60, 40], // Percentages from the image
            backgroundColor: [
                '#fd6e69ff',
                '#F0BB78',
            ],
            hoverOffset: 4,
            borderRadius: 8 
        }]
    };

    // Configuration for Deworming Chart
    const dewormingConfig = {
        type: 'doughnut',
        data: dewormingData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right', // Place legend on the right as in the image
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

    // Render Deworming Chart
    var dewormingChartCtx = document.getElementById('dewormingChart').getContext('2d');
    new Chart(dewormingChartCtx, dewormingConfig);

    // Data for PhilPEN Metrics Chart
    const philpenMetricsData = {
        labels: ['Completed', 'Missing'],
        datasets: [{
            data: [90, 10], // Percentages from the image
            backgroundColor: [
                '#279EFF', // Sky Blue for 90% (With completed record)
                '#697A8D'  // Gray for 10% (With missing record)
            ],
            hoverOffset: 4,
            borderRadius: 8 
        }]
    };

    // Configuration for PhilPEN Metrics Chart
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

    // Render PhilPEN Metrics Chart
    var philpenMetricsChartCtx = document.getElementById('philpenMetricsChart').getContext('2d');
    new Chart(philpenMetricsChartCtx, philpenMetricsConfig);

        // Your Medicine Stocks Data
    const medicineStocks = [
        { name: 'Medicine 1', stock: 21 },
        { name: 'Medicine 2', stock: 50 },
        { name: 'Medicine 3', stock: 101 },
        { name: 'Medicine 4', stock: 201 },
        { name: 'A Very Long Medicine Name That Needs Truncating', stock: 201 }, // Example long name
        { name: 'Medicine 6', stock: 201 },
        { name: 'Medicine 7', stock: 201 },
    ];

    const container = document.getElementById('medicineStocksChartContainer');

    // Find the maximum stock value to calculate percentages
    const maxStock = Math.max(...medicineStocks.map(item => item.stock));

    const barColorClass = 'bg-mainblue'; // Or 'bg-blue-500'

    medicineStocks.forEach(medicine => {
        const widthPercentage = maxStock > 0 ? (medicine.stock / maxStock) * 100 : 0;

        const medicineItemDiv = document.createElement('div');
        medicineItemDiv.className = 'flex items-center'; // Aligns name and bar horizontally

        // Create the div for Medicine Name (left side)
        const nameDiv = document.createElement('div');
        // --- CHANGES HERE: Reduced width and added truncate/overflow-hidden ---
        nameDiv.className = 'w-1/4 text-sm pr-2 overflow-hidden text-ellipsis whitespace-nowrap'; // w-1/4 for less space, pr-2 for padding, ellipsis for long names
        // Note: Tailwind's 'truncate' utility is equivalent to 'overflow-hidden text-ellipsis whitespace-nowrap'
        // So you could just use: nameDiv.className = 'w-1/4 text-sm pr-2 truncate';
        nameDiv.textContent = medicine.name;
        medicineItemDiv.appendChild(nameDiv);

        // Create the container for the bar and the number
        const barWrapperDiv = document.createElement('div');
        barWrapperDiv.className = 'relative flex-grow h-7 rounded';

        // Create the actual bar div
        const barDiv = document.createElement('div');
        barDiv.className = `${barColorClass} h-full rounded`;
        barDiv.style.width = `${widthPercentage}%`;

        // Create the span for the number inside the bar
        const stockNumberSpan = document.createElement('span');
        stockNumberSpan.textContent = medicine.stock;
        stockNumberSpan.className = 'absolute inset-y-0 left-2 flex items-center text-white text-sm font-medium';

        // Append elements
        barWrapperDiv.appendChild(barDiv);
        barWrapperDiv.appendChild(stockNumberSpan);

        medicineItemDiv.appendChild(barWrapperDiv);
        container.appendChild(medicineItemDiv);
    });
});

