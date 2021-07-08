$(document).ready(function() {

    var ctx = document.getElementById('performance').getContext('2d'); 
    var pie = document.getElementById('allocation').getContext('2d');
      
    const pieData = {
        labels: categories,
        datasets:[{
            label: 'My First Dataset',
            data: amount,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
            ],
        }], 
        hoverOffset: 4
    } 

    const pieOptions = { 
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    return '₱' + number_format(amount[tooltipItem.index])
                }
            }
        }, 
        maintainAspectRatio:false,
        reponsive:true
    }

    var pieChart = new Chart( pie, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    })
    
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [ 
            '0',
            '',
            '',
            '',
            '',
            '',
            '6',
            '',
            '',
            '',
            '',
            '',
            '12',
            '',
            '',
            '',
            '',
            '',
            '18',
            '',
            '',
            '',
            '',
            '23'
            ],
            datasets: [
            {
                label: 'Today ',
                data: dataset1,
                backgroundColor: [
                'rgba(37, 119, 181,0.5)',
                'rgba(37, 119, 181,0.5)',
                'rgba(37, 119, 181,0.5)',
                'rgba(37, 119, 181,0.5)',
                'rgba(37, 119, 181,0.5)',
                ],
                borderColor: [
                'rgba(66,139,202,0.5)',
                'rgba(66,139,202,0.5)',
                'rgba(66,139,202,0.5)',
                'rgba(66,139,202,0.5)',
                'rgba(66,139,202,0.5)',

                ],
                pointStyle: 'circle', 
                pointBackgroundColor: "rgba(255,255,255,0.1)",
                pointBorderColor: "rgba(244,244,244,0.1)",
                pointHoverBackgroundColor: "rgba(37, 119, 181,0.1)",
                pointHoverBorderColor: "rgba(244,244,244,0.1)",
                pointRadius: 1,
                pointHitRadius: 10,
                borderWidth: 3,
                fill:true
            },
            {
                label: 'Yesterday ',
                data: dataset2,
                backgroundColor: [
                'rgba(122, 146, 163,0.5)',
                'rgba(122, 146, 163,0.5)',
                'rgba(122, 146, 163,0.5)',
                'rgba(122, 146, 163,0.5)',
                'rgba(122, 146, 163,0.5)'
                ],
                borderColor: [
                'rgba(122, 146, 163,0.3)',
                'rgba(122, 146, 163,0.3)',
                'rgba(122, 146, 163,0.3)',
                'rgba(122, 146, 163,0.3)',
                'rgba(122, 146, 163,0.3)'
                ], 
                pointStyle: 'circle', 
                pointBackgroundColor: "rgba(255,255,255,0.4)",
                pointBorderColor: "rgba(244,244,244,0.5)",
                pointHoverBackgroundColor: "rgba(0, 0, 0,0.2)",
                pointHoverBorderColor: "rgba(244,244,244,0.5)",
                pointRadius: 1,
        pointHitRadius: 10,
                borderWidth: 3,
                fill:true
            },
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }, 
            responsive:true,
            maintainAspectRatio:false,
            tooltips: {
                callbacks: {
                    title: function(tooltipItem) { 
                        var day = tooltipItem[0].datasetIndex == 0 ? "TODAY" : "YESTERDAY";

                        return  day + ": 00:00 - " + (tooltipItem[0].index) + ":99"; 
                    },
                    label: function(tooltipItem, data) {
                        return '₱' + number_format(tooltipItem.yLabel);
                    }
                }
            },
        },
    });

    function number_format(number, decimals, dec_point, thousands_point) {

        if (number == null || !isFinite(number)) {
            throw new TypeError("number is not valid");
        }

        if (!decimals) {
            var len = number.toString().split('.').length;
            decimals = len > 1 ? len : 0;
        }

        if (!dec_point) {
            dec_point = '.';
        }

        if (!thousands_point) {
            thousands_point = ',';
        }

        number = parseFloat(number).toFixed(decimals);

        number = number.replace(".", dec_point);

        var splitNum = number.split(dec_point);
        splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
        number = splitNum.join(dec_point);

        return number;
    }
})