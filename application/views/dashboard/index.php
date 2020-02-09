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
</div>

<script src="<?php echo base_url('assets/vendor/chart.min.js') ?>"></script>
 
	<script>
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
                'rgba(66,139,202,0.4)',
                'rgba(66,139,202,0.4)',
                'rgba(66,139,202,0.4)',
                'rgba(66,139,202,0.4)',
                'rgba(66,139,202,0.4)',
            ],
            borderColor: [
                'rgba(66,139,202,0.5)',
                'rgba(66,139,202,0.4)',
                'rgba(66,139,202,0.4)',
                'rgba(66,139,202,0.4)',
                'rgba(66,139,202,0.4)',
            ],
            borderWidth: 2
        },
        {
            label: 'Yesterday ',
            data: dataset2,
            backgroundColor: [
                'rgba(0, 0, 0,0.2)',
                'rgba(0, 0, 0,0.2)',
                'rgba(0, 0, 0,0.2)',
                'rgba(0, 0, 0,0.2)',
                'rgba(0, 0, 0,0.2)'
            ],
            borderColor: [
                'rgba(0, 0, 0,0.2)',
                'rgba(0, 0, 0,0.2)',
                'rgba(0, 0, 0,0.2)',
                'rgba(0, 0, 0,0.2)',
                'rgba(0, 0, 0,0.2)'
            ],
            borderWidth: 2
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
                    return '₱' + tooltipItem.yLabel;
                }
            }
        }
    },
});
 
</script> 
  