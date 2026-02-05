document.addEventListener('DOMContentLoaded', function () {
    const summaryCtx = document.getElementById('summaryChart').getContext('2d');
    new Chart(summaryCtx, {
        type: 'bar',
        data: summaryChartData,
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'pie',
        data: genderChartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });


    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'pie',
        data: ageChartData,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    const employmentCtx = document.getElementById('employmentChart').getContext('2d');
    new Chart(employmentCtx, {
        type: 'pie',
        data: employmentChartData,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    const classificationCtx = document.getElementById('classificationChart').getContext('2d');
    new Chart(classificationCtx, {
        type: 'bar',
        data: classificationChartData,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    const documentCtx = document.getElementById('documentChart').getContext('2d');
    new Chart(documentCtx, {
        type: 'pie',
        data: documentChartData,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });


});
