// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myBarChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
        datasets: [{
            label: "Total",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: " rgb(26 181 66)",
            pointRadius: 3,
            pointBackgroundColor: "rgb(26 181 66)",
            pointBorderColor: "rgb(26 181 66)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgb(26 181 66)",
            pointHoverBorderColor: "rgb(26 181 66)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        }],
    },
    options: {
        plugins: {
            legend: {
                display: false,
            },
        },
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scale: {
            y: {
                beginAtZero: true,
                precision: 0,
                stepSize: 1,

            },
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
        }
    }
});

// Bar Chart Example
var ctx = document.getElementById("myBarChart2");
var myBarChart2 = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
        datasets: [{
            label: "Total",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgb(179 72 72)",
            pointRadius: 3,
            pointBackgroundColor: "rgb(179 72 72)",
            pointBorderColor: "rgb(179 72 72)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgb(179 72 72)",
            pointHoverBorderColor: "rgb(179 72 72)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        }],
    },
    options: {
        plugins: {
            legend: {
                display: false,
            },
        },
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scale: {
            y: {
                beginAtZero: true,
                precision: 0,
                stepSize: 1,

            },
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
        }
    }
});
