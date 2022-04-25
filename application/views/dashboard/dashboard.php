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
            <h3>Revenue</h3>
            Today: <span class="currency"><?php echo currency(); ?></span> <span class="result"><?php echo $sales; ?></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="widget-box">
            <h3>Expenses</h3>
            Today: <span class="currency"><?php echo currency(); ?></span> <span class="result"><?php echo $expenses ?></span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="widget-box">
            <h3>Total Inventory</h3>
            Current: <span class="currency"><?php echo currency(); ?></span> <span class="result"><?php echo $inventory_value ?></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
           <div class="panel-heading">
               <i class="fa fa-bar-chart"></i> Sales Performance
           </div> 
           <div class="panel-body"> 
                <div style="height:360px;"><canvas id="performance" width="400"  style="height: 500px;"></canvas> </div>
            </div>  
        </div> 
        <br/>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-trophy"></i> Overview of best selling products
            </div> 
            <div class="panel-body"> 
             
             <table class="table table-hover table-striped">
                 <thead>
                     <tr>
                         <th colspan="">#</th>
                         <th>Product Name</th>
                         <th>Sold</th>
                         <th>Qty. Remaining</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php if ($top_products): ?>
                         <?php foreach ($top_products as $key => $row): ?>
                             <tr>
                                 <td><?php echo $key + 1 ?></td>
                                 <td><?php echo $row->name ?></td>
                                 <td><?php echo $row->qty ?></td>
                                 <td><?php echo $row->quantity ?? 0 ?></td>
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
    <div class="col-md-4">
        <div class="row">  
            
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-pie-chart"></i> Top 5 Categories Inventory Allocation
                    </div>
                    <div class="panel-body" style="min-height:270px;padding-bottom:10">
                        <canvas id="allocation" ></canvas> 
                    </div>
                </div>
                <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-question-circle" title="Identify products status"></i> Diagnoses
                </div> 
                <div class="panel-body">  
                        <table class="table table-hover"> 
                            <thead>
                                <tr>
                                    
                                    <td>Short Stock</td>
                                    <td>Out of stocks</td>
                                    <td>Not Selling</td>
                                </tr>
                            </thead> 
                            <tr style="background-color: #f9f9f9;">
                                
                                <td style="font-size: 24px;padding: 12px">
                                    <a href="<?php echo base_url('diagnoses?active=2') ?>">
                                    <span style="color: #333" title="Number of products that stocks are below 15" data-toggle="tooltip"><?php echo $low_stocks ?></span> 
                                    </a>       
                                </td>
                                <td style="font-size: 24px;padding: 12px">
                                    <a href="<?php echo base_url('diagnoses?active=3') ?>">
                                    <span style="color: #333" title="Run out of stocks" data-toggle="tooltip"><?php echo $no_stocks ?></span> 
                                    </a>       
                                </td>
                                <td  style="font-size: 24px;padding: 12px">
                                    <a href="<?php echo base_url('diagnoses') ?>">
                                    <span style="color: #333" data-toggle="tooltip" title="Number of products that are not selling for the last 30 days"><?php echo $not_selling ?></span>
                                    </a>
                                </td>
                            </tr> 
                        </table>
                        <table class="table table-hover">
                    
                            <thead>
                                <tr>
                                    <td><i class="fa fa-question-circle" title="Average sales per day for the last 30 days"></i> Average Sales Per Day</td> 
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
<style type="text/css">
    .panel-heading {
        font-weight: bold;
    }
</style>
<script>
    var dataset1 = <?php echo $dataset ?>;
    var dataset2 = <?php echo $yesterday ?>;  
    var categories = <?php echo json_encode($categories) ?>;
    var amount = <?php echo json_encode($total) ?>;
 
</script>
<script src="<?php echo base_url('assets/vendor/chart.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/charts.js') ?>"></script>