<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Sales Reports</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row"> 
	 
		<div class="col-md-3">
			<div class="form-group">
				<div class="btn-group" id="btn-group-menu" role="group" aria-label="Basic example">
					<button type="button" class="btn btn-default " data-id="graph">Graphical View</button>
					<button type="button" class="btn btn-default active" data-id="table">Table View</button> 
				</div>
			</div>
		</div>
		<div  id="table-menu">
			<div class="col-md-6" >
				<div class="form-group">
					<div class="input-group input-daterange">
						<input type="text" id="min-date" value="<?php echo date('Y-m-d') ?>" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">
						<div class="input-group-addon">to</div>
						<input type="text" id="max-date" value="<?php echo date('Y-m-d') ?>" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:" data-date-min-date="2019-04-18" >
					</div>
				</div>
			</div>
			<div class="col-md-3 text-right">
				<!-- <div class="form-group">
					<button class="btn btn-default" id="export"><i class="fa fa-file-pdf-o"></i> Export</button>
				</div> -->
			</div>
		</div> 

	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Sales Reports 
			</div>

			<!-- /.panel-heading -->
			<div class="panel-body">
				<div id="widgets"> 
					 
					
					<div class="col-md-2">
						<div class="sale-widget text-center">
							Total Expenses <i class="fa fa-question-circle" data-toggle="tooltip" title="Total expenses is sum of total amount of expenses in a given period of time" style="font-size: 16px;"></i><br>
							<b><span id="total-expense"></span></b>
						</div>
					</div>  

					<div class="col-md-2">
						<div class="sale-widget text-center">
							Total Sales <i class="fa fa-question-circle" data-toggle="tooltip" title="Total sales is the total amount of sales in a given period of time. Formulated as (Total Number of units sold *(times) price per unit" style="font-size: 16px;"></i><br>
							<b><span id="total-sales"></span></b>
						</div>
					</div>

					<div class="col-md-2">
						<div class="sale-widget text-center">
							Cost of Goods Sold <i class="fa fa-question-circle" data-toggle="tooltip" title="Total expenses is sum of total amount of expenses in a given period of time" style="font-size: 16px;"></i><br>
							<b><span id="total-goods-cost"></span></b>
						</div>
					</div>

					<div class="col-md-2">
						<div class="sale-widget text-center">
							Gross Profit <i class="fa fa-question-circle" data-toggle="tooltip" title="Gross Profit is the total amount a company makes after deducting the costs associated with making and selling its products." style="font-size: 16px;"></i><br>
							<b><span id="total-gross"></span></b>
						</div>
					</div> 
					<div class="col-md-2">
						<div class="sale-widget text-center">
							Net Income <i class="fa fa-question-circle" data-toggle="tooltip" title="Net Income is equal to total revenue after expenses." style="font-size: 16px;"></i><br>
							<b><span id="total-net"></span></b>
						</div>
					</div> 
					
				</div>

				<div class="col-md-6" id="graph-menu" style="display: none;">
					<div class="btn-group pull-center" role="group" aria-label="Basic example">
						<button type="button" class="btn btn-default active" id="default-filter" data-id="week">Last 7 Days</button>
						<button type="button" class="btn btn-default" data-id="month">Monthly</button> 
						<button type="button" class="btn btn-default" data-id="year">Yearly</button>
					</div>
				</div>
				<div class="col-lg-12" id="graph" style="display: none;">

					<canvas id="myChart" width="400" height="150"></canvas>
				</div>
				<div class="col-lg-12"  id="table_view">
					<?php if ($this->session->flashdata('success')): ?>
						<div class="alert alert-success">
							<?php echo $this->session->flashdata('success') ?>
						</div>
					<?php endif; ?>
					<table class="table table-bordered table-stripped" id="sales_table" style="width: 100%">
						<thead>
							<tr>
								<th >Date</th> 
								<th >Staff</th>
								<th >Item Name</th> 
								<th >Quantity</th>
								<th> Returned</th>
								<th >Capital</th>
								<th >Price</th>
								<th>Discount</th> 
								<th >Total</th>   
								<th> Transaction Profit</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Sales Summary</h5>

			</div>
			<div class="modal-body">
				<div>
					Sales ID: <span id="sale-id"></span>
					<br>
				</div>
				<table style="width: 100%;" class="table table-bordered table-hover table-striped" id="sales-description-table">
					<thead>
						<tr>
							<td>Item ID</td>
							<td>Item Name</td> 
							<td>Price</td>
							<td>Quantity</td>
							<td>Sub Total</td>
						</tr>
					</thead>
					<tbody> 
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/vendor/chart.min.js') ?>"></script>
<script type="text/javascript">
	
	window.onload = function() {
		var labels = JSON.parse('<?php echo json_encode(array_keys($dataset)) ?>');
		var totalSales = JSON.parse('<?php echo json_encode(array_values($dataset)) ?>');

		var ctx = document.getElementById("myChart");
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: labels,
				datasets: [{
					label: 'Sales for the Last 7 Days',
					data: totalSales,
					backgroundColor: [
					'#337ab7',
					],
					strokeColor: [
					'#337ab7',
					],
					borderWidth: 1,
					callback: function(value, index, values) {
						console.log(values);
					}
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true,
							callback : function(value, index, values) {
								return '₱' + (number_format(parseFloat(values)));

							}
						}
					}]
				},
				tooltips: {
					callbacks: {
						label: function(tooltipItem, data) {
		                return ' ₱' + (number_format(parseFloat(tooltipItem.yLabel)));
		            }
					}
				}
			}
		}); 

		var base_url = $("meta[name='base_url']").attr('content');
		var currency = '₱';
		var site_live = $("meta[name='site_live']").attr('content');
		var csrfName = $("meta[name='csrfName']").attr('content');
		var csrfHash = $("meta[name='csrfHash']").attr("content");
		var api_key = $("meta[name='api_key']").attr('content');

		$("#graph-menu button").click(function() {
		$('#graph-menu button').removeClass('active');
		$(this).addClass('active');
		var type = $(this).data('id');
		var btn = $(this).button('loading');
		var data = {};
		data[csrfName] = csrfHash;
		data['type'] = type;
		$.ajax({
				type : 'POST',
				url : base_url + 'sales/graph-filter',
				data : data,
				success : function(data) { 
					var result = JSON.parse(data); 
					
					if (type == "week")
						myChart.data.datasets[0].label = "Sales for the last 7 Days";
					else if (type == "month")
						myChart.data.datasets[0].label = "Monthly Sales";
					else if (type == "year")
						myChart.data.datasets[0].label = "Yearly Sales";

					myChart.data.labels = Object.keys(result);
					myChart.data.datasets.data = Object.values(result);
					myChart.data.datasets[0].data = Object.values(result);
					myChart.update();
					btn.button("reset");

				}
			});
		}); 
	}

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

</script>


