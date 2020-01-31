<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Sales Description</h1> 
    </div>
    <div class="col-md-12">
        <?php 
        echo $this->session->flashdata('errorMessage');
        echo $this->session->flashdata('successMessage'); 
        ?>
    </div>
</div>
<div class="row"> 
    <div class="col-lg-12">
     <div class="panel panel-default">
 	
         <div class="panel-body">
         	<table style="font-size: 16px;">
         		<tr>
         			<th>Date:</th>
         			<td style="border-bottom: padding: 7px 10px;"><?php echo date('Y-m-d', strtotime($sales->date_time)) ?></th>
         		</tr>
         		<tr>
         			<th>Customer:</th>
         			<td style="border-bottom: padding: 7px 10px;"><?php echo $sales->customer_name ?></td>
         		</tr>
         		<tr>
         			<th>Payment Type:&nbsp;&nbsp;&nbsp;</th>
         			<td style="border-bottom: padding: 7px 10px;"><?php echo $sales->type ?></td>
         		</tr> 
         		<tr>
         			<th>Sales Person:&nbsp;&nbsp;&nbsp;</th>
         			<td style="border-bottom: padding: 7px 10px;"><?php echo $sales->user_name ?></td>
         		</tr> 
         	</table>
         	<br/>
         	
         	<table class="table table-bordered table-striped">
         		<thead>
         			<tr>
         				<td colspan="4">Order Details</td>
         			</tr>
         			<tr>
         				<th>Description</th>
	         			<th>Price</th>
	         			<th>Quantity</th>
	         			<th>Sub Total</th>
         			</tr>
         		</thead>
         		<tbody>
         			<?php foreach ($orderline as $key => $order): ?>
         				<tr>
         					<td><?php echo $order->name ?></td>
         					<td><?php echo $order->price ?></td>
         					<td><?php echo $order->quantity ?></td>
         					<td><?php echo currency() . number_format($order->price * $order->quantity,2) ?></td>
         				</tr>
         				<?php 
         					$total += $order->price * $order->quantity;
         				?>
         				<?php if ($key == count($orderline) - 1): ?>
         					<tr>
         						<td colspan="3" class="text-right">Total: </td>
         						<td><?php echo currency() . number_format($total) ?></td>
         					</tr>
         				<?php endif; ?>
         			<?php endforeach; ?>
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
