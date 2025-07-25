document.addEventListener("DOMContentLoaded", function () {
    const ctx2 = document.getElementById('familyBar').getContext('2d');

    // Purok Labels
    const purokLabels = [
    'Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5',
    'Purok 6', 'Purok 7', 'Purok 8', 'Purok 9', 'Purok 10'
    ];

    // Sample total family data per purok
    const totalFamilies = [100, 80, 120, 90, 70, 110, 85, 95, 105, 75];

    // Sample 4Ps member families per purok
    const fourPsFamilies = [40, 30, 50, 20, 25, 45, 35, 30, 60, 20];

    // Calculate non-4Ps families (total - 4Ps)
    const nonFourPsFamilies = totalFamilies.map((total, i) => total - fourPsFamilies[i]);

    const chart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: purokLabels,
            datasets: [
                {
                    label: 'Non-4Ps Families',
                    data: nonFourPsFamilies,
                    backgroundColor: '#fcd34d' // Amber
                },
                {
                    label: '4Ps Families',
                    data: fourPsFamilies,
                    backgroundColor: '#4ade80' // Green
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Families'
                    }
                }
            },
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        footer: (items) => {
                            const sum = items.reduce((acc, item) => acc + item.parsed.y, 0);
                            return `Total: ${sum}`;
                        }
                    }
                },
                legend: {
                    position: 'top'
                }
            }
        }
    }); 
}); 