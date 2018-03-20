<div class="col-sm-10" id="main">
	<div id="content">
	<?php
	$total = 0;
	?>
	<?php echo form_fieldset('<h1 class="text-danger">Sales Report</h1>'); ?>
		<nav>
			<ul id="sales-nav">
				<li>
				<i class="fa fa-calendar" aria-hidden="true">1</i>
				<a href="<?php echo base_url('daily_sales_report') ?>">Today's Sales</a></li>
				<li>
				<i class="fa fa-calendar" aria-hidden="true">7</i>
				<a href="<?php echo base_url('weekly_sales_report') ?>">This Week</a></li>
				<li>
				<i class="fa fa-calendar" aria-hidden="true">30</i>
				<a href="<?php echo base_url('monthly_sales_report') ?>">Monthly Sales</a></li>
				<li>
				<i class="fa fa-calendar" aria-hidden="true">1Y</i>
				<a href="<?php echo base_url('yearly_sales_report') ?>">Annual Sales</a></li>
			</ul>
		</nav>
		<br><br>
		<?php echo form_fieldset("<h1 class='text-danger'>$title</h1>"); ?>
		<table class="table table-striped">
<tr>
	<th>Date/Time</th>
	<th>Item Name</th>
	<th>Price</th>
	<th>Quantity</th>
	<th>Subtotal</th>
</tr>
	<?php foreach ($reports as $report) :?>
		<tr>
			<td><?php echo $report->date_time ?></td>
			<td><?php echo $report->item_name ?></td>
			<td><?php echo $report->item_price ?></td>
			<td><?php echo $report->quantity ?></td>
			<td><?php echo $report->sub_total ?></td>
		</tr>
		<?php 

		$total = $total + $report->sub_total;
		
		?>
	<?php endforeach ?>
</table>
<p style="border-top: 0.5px silver solid; padding-top: 5px;">
<label class="lead">Total Sales Today: 
<?php
	if($total > 0) {
		echo '₱'.$total;
	}
?>	
</label>
</p>
	</div>
</div>

