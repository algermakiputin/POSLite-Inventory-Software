 
<div class="row">
 <div class="col-md-12">
 <h1 class="page-header">Sales Report</h1>
 </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Sales overview</div>
    <div class="panel-body pad-0" >
        <ul class="nav nav-tabs" id="sales-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Daily</a></li>
            <li><a data-toggle="tab" href="#menu1" id="tab2">Weekly</a></li>
            <li><a data-toggle="tab" href="#menu2" id="tab3">Monthly</a></li>
        </ul> 
        <div class="tab-content" id="sales-tabs-content">
            <div id="home" class="tab-pane fade in active">
                 <div style="height:320px;">
                    <canvas id="dailyChart" height="400"></canvas>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <div style="height:320px">
                <canvas id="weeklyChart" height="400"></canvas>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade">
                <div style="height:320px">
                <canvas id="monthlyChart" height="400"></canvas>
                </div>
            </div>
        </div>
        
        <div id="summary-wrapper">
            <div class="row">
                <div class="col-md-4">
                    <div class="sales-widget">
                        <div class="title">Today</div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="amount"><?php echo $todaysSales ?></div>
                                <div class="caption">Sales</div>
                            </div>
                            <div class="col-lg-6">
                                <div class="amount"><?php echo $todaysProfit ?></div>
                                <div class="caption">Profit</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sales-widget">
                        <div class="title">Best Ever</div>
                        <div class="amount"><?php echo $bestEver ?></div>
                        <div class="caption">Sales</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sales-widget">
                    <div class="title">All Time</div>
                        <div class="amount"><?php echo $allTimeSales; ?></div>
                        <div class="caption">Sales</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/vendor/chart.min.js') ?>"></script> 

<script>
 
    $(document).ready(function() {
        
        const currency = '₱'
        const dailySales = <?php echo json_encode(array_values($daily['sales'])) ?>;
        const dailyProfit = <?php echo json_encode(array_values($daily['profit'])) ?>;
        const dailyChart = $("#dailyChart")[0].getContext("2d");
        var dailyChartData = {
            labels: <?php echo json_encode(array_keys($daily['sales'])) ?>,
            datasets: [
                {
                    label: ' Sales',
                    data: dailySales,
                    backgroundColor: 'rgba(37, 119, 181,0.65)',
                    borderWidth: 1
                },
                {
                    label: 'Profit',
                    data: dailyProfit,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderWidth: 1
                }
            ]
            
        } 
        var dailyChartOptions = { 
            responsive: true,
            maintainAspectRatio:false,
            scales: {
                xAxes: [{
                    ticks: {
                        callback: function(tick, index, array) {
                            return (index % 4) ? "" : tick;
                        },
                        autoSkip: false,
                        maxRotation: 0,
                        minRotation: 0,
                        beginAtZero: true
                    }
                }],
                yAxes: [{
                    ticks: {
                        callback: function(tick, index, array) {
                            return currency + number_format(tick); 
                        },
                        beginAtZero: true
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return currency + number_format(tooltipItem.yLabel); 
                    }
                }
            }
        }

        var dailyBarChart = new Chart(dailyChart, { 
            type:'bar',
            data: dailyChartData, 
            options: dailyChartOptions
        })



        $("#tab2").click(function(e) {
            var url = '<?php echo base_url('SalesController/getWeeklySales') ?>';
            $.get(url, function(data, status) {
                
                var result = JSON.parse(data);
                var weeklyChart = $("#weeklyChart")[0].getContext('2d');
                console.log(result)
                var weeklyChartData = {
                    labels: result.labels,
                    datasets: [
                        {
                            label: ' Sales',
                            data: result.sales,
                            backgroundColor: 'rgba(37, 119, 181,0.65)',
                            borderWidth: 1
                        },
                        {
                            label: 'Profit',
                            data: result.profit,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderWidth: 1
                        }
                    ]
                    
                } 
                var weeklyChartOptions = { 
                    responsive: true,
                    maintainAspectRatio:false,
                    scales: {
                        xAxes: [{
                            ticks: {
                                callback: function(tick, index, array) {
                                    return (index % 6) ? "" : tick;
                                },
                                autoSkip: false,
                                maxRotation: 0,
                                minRotation: 0
                            },
                            beginAtZero: true
                        }],
                        yAxes: [{
                            ticks: {
                                callback: function(tick, index, array) {
                                    return currency + number_format(tick); 
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return currency + number_format(tooltipItem.yLabel); 
                            }
                        }
                    }
                }
                var dailyBarChart = new Chart(weeklyChart, { 
                    type:'bar',
                    data: weeklyChartData, 
                    options: weeklyChartOptions
                });
            }) 
        })

        $("#tab3").click(function(e) {
            var url = '<?php echo base_url('SalesController/getMonthlySales') ?>';
            $.get(url, function(data, status) {
                
                var result = JSON.parse(data);
                console.log(result)
                var weeklyChart = $("#monthlyChart")[0].getContext('2d');
                weeklyChart.height = 500;
                var monthlyChartData = {
                    labels: result.labels,
                    datasets: [
                        {
                            label: ' Sales',
                            data: result.sales,
                            backgroundColor: 'rgba(37, 119, 181,0.65)',
                            borderWidth: 1
                        },
                        {
                            label: 'Profit',
                            data: result.profit,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderWidth: 1
                        }
                    ]
                    
                } 
                var monthlyChartOptions = {  
                    maintainAspectRatio:false,
                    scales: {
                        xAxes: [{
                            ticks: {
                                callback: function(tick, index, array) {
                                    return (index % 3) ? "" : tick;
                                },
                                autoSkip: false,
                                maxRotation: 0,
                                minRotation: 0
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                callback: function(tick, index, array) {
                                    return currency + number_format(tick); 
                                }
                            },
                            beginAtZero: true
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return currency + number_format(tooltipItem.yLabel); 
                            }
                        }
                    }
                }
                var dailyBarChart = new Chart(weeklyChart, { 
                    type:'bar',
                    data: monthlyChartData, 
                    options: monthlyChartOptions
                });
            })
           
        })

        function number_format(number, decimals, dec_point, thousands_point) {
 	
            toFixed = "";

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

            if (number % 1 === 0)
                toFixed = ".00";

            number = parseFloat(number).toFixed(decimals);

            number = number.replace(".", dec_point);

            var splitNum = number.split(dec_point);
            splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
            number = splitNum.join(dec_point);

 

            return number + toFixed;
        }
    })
</script>