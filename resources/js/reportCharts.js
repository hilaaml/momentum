import Chart from 'chart.js/auto';


window.initReportCharts = function(byDay, byHour, projectLabels, projectValues) {
    
    // 1. Bar Chart: Hari Paling Aktif
    const ctxDays = document.getElementById('activeDaysChart');
    if (ctxDays) {
        new Chart(ctxDays, {
            type: 'bar',
            data: {
                labels: Object.keys(byDay), // ['Senin', 'Selasa', ...]
                datasets: [{
                    label: 'Total Waktu (jam)',
                    data: Object.values(byDay).map(sec => (sec / 3600).toFixed(2)),
                    backgroundColor: 'rgba(99, 102, 241, 0.6)'
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // 2. Line Chart: Jam Paling Aktif
    const ctxHours = document.getElementById('hourlyChart');
    if (ctxHours) {
        new Chart(ctxHours, {
            type: 'line',
            data: {
                labels: Object.keys(byHour), // ['00', '01', ..., '23']
                datasets: [{
                    label: 'Waktu Aktif per Jam (menit)',
                    data: Object.values(byHour).map(sec => (sec / 60).toFixed(1)),
                    borderColor: 'rgba(255, 99, 132, 0.7)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // 3. Pie Chart: Waktu per Proyek
    const ctxPie = document.getElementById('projectPieChart');
    if (ctxPie) {
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: projectLabels,
                datasets: [{
                    data: projectValues,
                    backgroundColor: [
                        '#6366f1', '#f59e0b', '#10b981', '#ef4444', '#3b82f6',
                        '#8b5cf6', '#14b8a6', '#ec4899', '#f97316', '#84cc16'
                    ]
                }]
            }
        });
    }
};
