<div class="col-sm-10" id="main">
	<div id="content">
	<?php
	$total = 0;
	?>
	<?php echo '<h1 class="page-title">Sales Report</h1>'; ?>
			<?php 
				$currentPage = $this->uri->segment(2);
			?>
			<ul id="sales-nav">
				<li>
				
					<a href="<?php echo base_url('sales/daily') ?>" <?php
						if ($currentPage == "daily")
							echo "class='active'"
					 ?> >
						1 <i class="fa fa-calendar" aria-hidden="true"></i> 
						 Today's Sales
					</a>
				</li>

				<li>
					<a href="<?php echo base_url('sales/weekly') ?>" <?php
						if ($currentPage == "weekly")
							echo "class='active'"
					 ?> >
						7 <i class="fa fa-calendar" aria-hidden="true"></i> This Week
					</a>
				</li>
				
				<li>
					<a href="<?php echo base_url('sales/monthly') ?>" <?php
						if ($currentPage == "monthly")
							echo "class='active'"
					 ?>>
						30 <i class="fa fa-calendar" aria-hidden="true"></i> Monthly Sales
					</a>
				</li>
				<li>
					<a href="<?php echo base_url('sales/yearly') ?>" <?php
						if ($currentPage == "yearly")
							echo "class='active'"
					 ?>>
						1Y <i class="fa fa-calendar" aria-hidden="true"></i> Annual Sales
					</a>
				</li>
				<div class="clearfix"></div>
			</ul>
			
		<br>
	
		<table class="table table-striped table-bordered">
<tr>
	<th>Date/Time</th>
	<th>Item Name</th>
	<th>Price</th>
	<th>Quantity</th>
	<th>Subtotal</th>
</tr>
	<?php if($reports) : ?>
		<?php foreach ($reports as $report) :?>
			<tr>
				<td><?php echo $report->date_time ?></td>
				<td><?php echo $model->getDetails($report->item_id)->name ?> </td>
				<td><?php echo $price->getPrice($report->price_id) ?></td>
				<td><?php echo $report->quantity ?></td>
				<td><?php echo $report->sub_total ?></td>
			</tr>
			<?php 

			$total = $total + $report->sub_total;
			
			?>
		<?php endforeach ?>
	<?php endif; ?>
</table>
<p style="border-top: 0.5px silver solid; padding-top: 5px;">
 
<?php
	if($total > 0) {
		echo "<label class='lead'>Total Sales:" .'₱'.$total . "</label>";
	}else {
		echo "<label class='lead'>Nothing to show...</label>";
	}
?>	

</p>
	</div>
</div>

