// Enrolled Residents Line Chart (Last 5 Months)
const residentsLineCtx = document.getElementById('residentsLineChart')?.getContext('2d');
if (residentsLineCtx && enrolledStatsData && enrolledStatsData.length > 0) {
    const datasets = enrolledStatsData.map((program, index) => {
        const colors = ['#3b82f6', '#10b981', '#f59e0b'];
        return {
            label: program.program_name,
            data: program.monthly_data.map(m => m.count),
            borderColor: colors[index % colors.length],
            backgroundColor: colors[index % colors.length] + '20',
            tension: 0.4,
            fill: false
        };
    });

    new Chart(residentsLineCtx, {
        type: 'line',
        data: {
            labels: enrolledStatsData[0].monthly_data.map(m => m.month),
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// PhilPEN Donut Chart
const philpenCtx = document.getElementById('philpenMetricsChart')?.getContext('2d');
if (philpenCtx && philpenStatsData) {
    new Chart(philpenCtx, {
        type: 'doughnut',
        data: {
            labels: ['Complete', 'Incomplete', 'No Consultation'],
            datasets: [{
                data: [
                    philpenStatsData.complete,
                    philpenStatsData.incomplete,
                    philpenStatsData.no_consultation
                ],
                backgroundColor: [
                    '#10b981',
                    '#f59e0b',
                    '#ef4444'
                ],
                borderColor: '#fff',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}