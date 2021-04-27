 
<h1 class="page-header">Sales Report</h1>

<div class="panel panel-default">
    <div class="panel-heading">Sales overview</div>
    <div class="panel-body pad-0" >
        <ul class="nav nav-tabs" id="sales-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Daily</a></li>
            <li><a data-toggle="tab" href="#menu1">Weekly</a></li>
            <li><a data-toggle="tab" href="#menu2">Monthly</a></li>
        </ul> 
        <div class="tab-content" id="sales-tabs-content">
            <div id="home" class="tab-pane fade in active">
                 <div style="height:300px;">
                 <canvas id="dailyChart" height="400"></canvas>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                 
            </div>
            <div id="menu2" class="tab-pane fade">
                 
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
                            return (index % 6) ? "" : tick;
                        },
                        autoSkip: false,
                maxRotation: 0,
                minRotation: 0
                    }
                }]
            }
        }

        var dailyBarChart = new Chart(dailyChart, { 
            type:'bar',
            data: dailyChartData, 
            options: dailyChartOptions
        })

    })
</script>