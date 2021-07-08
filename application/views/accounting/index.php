<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Accounting</h1>
	</div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
   <div class="col-lg-12">
       <div class="panel panel-default">
           <div class="panel-heading">
               Accounting Reports
           </div>

           <!-- /.panel-heading -->
        <div class="panel-body">
                <div class="col-md-3">
                  <!--   <div class="btn-group" id="btn-group-menu" role="group">
                        <button type="button" class="btn btn-default active" data-id="graph">Graph</button>
                        <button type="button" class="btn btn-default" data-id="table">Inventory</button> 
                    </div> -->
                    
                </div>
                <div class="col-md-6" >
             
                    <div class="input-group input-daterange" id="accounting-filter">

                      <input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

                      <div class="input-group-addon">to</div>

                      <input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">

                    </div>


                </div>
               
                <div class="col-lg-12" id="graph" style="display: none;">
                    <canvas id="profit" width="400" height="150"></canvas>
                </div>
                <div class="col-md-12" id="table_view">
                    <h5><span id="range">Today's Report</span> <span class="pull-right">Total Profit:
                    <span id="total-profit"><?php echo number_format($profit,2) ?></span>
                    </span></h5>
                    <table width="100%" class="table table-bordered table-striped" id="profit_table">
                        <thead>
                            <tr>
                                <th width="20%">Item Name</th>
                                <th width="20%">Sold</th>
                                <th width="20%">Capital</th>
                                <th width="20%">Revenue</th>
                                <th width="20%">Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                           <!--  <?php if ($items): ?>
                                <?php foreach( $items as $item ):  ?>
                                    <tr>
                                        <td><?php echo $item['name'] ?></td>
                                        <td><?php echo $item['sold'] ?></td>
                                        <td><?php echo '₱' . $item['capital'] ?></td>
                                        <td><?php echo '₱' . $item['revenue'] ?></td>
                                        <td><?php echo '₱' . $item['profit'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif;?> -->
                        </tbody>
                    </table>
                </div>
        </div>
        <!-- /.panel-body -->
    </div>
<!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>
<script src="<?php echo base_url('assets/vendor/chart.min.js') ?>"></script>
<script type="text/javascript">
    var profit = JSON.parse('<?php echo json_encode(array_values($graph)) ?>')
    var labels = JSON.parse('<?php echo json_encode(array_keys($graph)) ?>')

    var cProfit = document.getElementById("profit");

    var myProfit = new Chart(cProfit, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Profit',
                data: profit,
                backgroundColor: [
                    '#337ab7',
                ],
                strokeColor: [
                    '#337ab7',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        callback : function(value, index, values) {
                            return '₱' + (value);

                        }
                    }
                }]
            }
        }
    });
</script>

 



