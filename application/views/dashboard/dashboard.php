<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1> 
    </div> 
</div>

<?php 
echo $this->session->flashdata('errorMessage');
echo $this->session->flashdata('successMessage'); 
?>
<div class="row">
    <div class="col-md-3">
        <div class="widget-box">
            <h3>Orders</h3>
            Today: <span class="result"><?php echo $orders ?></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="widget-box">
            <h3>Sales</h3>
            <span class="currency"><?php echo currency(); ?></span> <span class="result"><?php echo $sales; ?></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="widget-box">
            <h3>Expenses</h3>
            <span class="currency"><?php echo currency(); ?></span> <span class="result"><?php echo $expenses ?></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="widget-box">
            <h3>Revenue</h3>
            <span class="currency"><?php echo currency(); ?></span> <span class="result"><?php echo $revenue ?></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
           <div class="panel-heading">
               Performance
           </div> 
           <div class="panel-body"> 
            <canvas id="performance" width="400"  style="max-height: 500px;"></canvas> 
        </div> 
    </div> 
</div>
<div class="col-md-4">
    <div class="row"> 
        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   Product Ranking: <?php echo date('Y/m/d') ?>
               </div> 
               <div class="panel-body"> 
                
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th colspan="2">#</th>
                            <th>Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($top_products): ?>
                            <?php foreach ($top_products as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $row->name ?></td>
                                    <td><?php echo $row->qty ?></td>
                                </tr> 
                            <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">Not enough data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table> 
                </div> 
            </div> 
        </div>


        <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   Diagnoses
               </div> 
               <div class="panel-body"> 
                   
                    <table class="table table-hover">
                   
                        <thead>
                            <tr>
                                <td>Not Selling</td>
                                <td>Short Stock</td>
                                <td>Out of stocks</td>
                            </tr>
                        </thead>
                        
                        <tr style="background-color: #f9f9f9;">
                            <td  style="font-size: 24px;padding: 15px">
                                <a href="<?php echo base_url('diagnoses') ?>">
                                <span style="color: #333" data-toggle="tooltip" title="Number of products that are not selling for the last 7 days"><?php echo $not_selling ?></span>
                                </a>
                            </td>
                            <td style="font-size: 24px;padding: 15px">
                                <a href="<?php echo base_url('diagnoses') ?>">
                                <span style="color: #333" title="Number of products that stocks are below 15" data-toggle="tooltip"><?php echo $low_stocks ?></span> 
                                </a>       
                            </td>
                            <td style="font-size: 24px;padding: 15px">
                                <a href="<?php echo base_url('diagnoses') ?>">
                                <span style="color: #333" title="Run out of stocks" data-toggle="tooltip"><?php echo $no_stocks ?></span> 
                                </a>       
                            </td>
                        </tr>
                        
                    </table>
                    <table class="table table-hover">
                   
                        <thead>
                            <tr>
                                <td>Average Sales Per Day</td> 
                            </tr>
                        </thead>
                        <tr>
                            <td  style="font-size: 24px;padding: 15px">
                                <span data-toggle="tooltip" title="Average sales per day for the last 30 days"><?php echo $average_sales_per_day ?></span>
                            </td> 
                        </tr> 
                    </table>
                </div> 
            </div> 
        </div> 
    </div>
</div>
</div>
<br/>
<script src="<?php echo base_url('assets/vendor/chart.min.js') ?>"></script>

<script>

    $(document).ready(function() {

        var ctx = document.getElementById('performance').getContext('2d');
        var dataset1 = <?php echo $dataset ?>;
        var dataset2 = <?php echo $yesterday ?>;

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
                    'rgba(37, 119, 181,1)',
                    'rgba(37, 119, 181,1)',
                    'rgba(37, 119, 181,1)',
                    'rgba(37, 119, 181,1)',
                    'rgba(37, 119, 181,1)',
                    ],
                    borderColor: [
                    'rgba(66,139,202,0.5)',
                    'rgba(66,139,202,0.4)',
                    'rgba(66,139,202,0.4)',
                    'rgba(66,139,202,0.4)',
                    'rgba(66,139,202,0.4)',

                    ],
                    pointStyle: 'circle', 
                    pointBackgroundColor: "rgba(255,255,255,0.4)",
                    pointBorderColor: "rgba(244,244,244,0.5)",
                    pointHoverBackgroundColor: "rgba(37, 119, 181,1)",
                    pointHoverBorderColor: "rgba(244,244,244,0.5)",
                    pointRadius: 1,
            pointHitRadius: 10,
                    borderWidth: 3
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
                    borderWidth: 3
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

</script> 