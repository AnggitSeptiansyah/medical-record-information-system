import Chart from 'chart.js/auto';

export function initializeCharts(monthlyVisitsData, genderDistributionData) {
    // Monthly Visits Chart
    const monthlyCtx = document.getElementById('monthlyVisitsChart');
    if (monthlyCtx) {
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const labels = monthlyVisitsData.map(item => monthNames[item.month - 1] + ' ' + item.year);
        const data = monthlyVisitsData.map(item => item.total);

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kunjungan',
                    data: data,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Gender Distribution Chart
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx) {
        const genderLabels = genderDistributionData.map(item => item.gender === 'male' ? 'Laki-laki' : 'Perempuan');
        const genderCounts = genderDistributionData.map(item => item.total);

        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: genderLabels,
                datasets: [{
                    data: genderCounts,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
}
