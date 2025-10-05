
    const ctx2 = document.getElementById('familyBar').getContext('2d');

    const purokLabels = Object.keys(window.familiesPerPurok); // e.g. ['Purok 1', 'Purok 2', ...]
    const totalFamilies = Object.values(window.familiesPerPurok);
    const fourPsFamilies = Object.values(window.families4PsPerPurok);
    const indigentFamilies = Object.values(window.familiesIndigentPerPurok);
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
