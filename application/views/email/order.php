<!DOCTYPE html>
<html>
<head>
	<title>Out of Stocks</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
</head>

<body style="padding: 20px;">
<h1>Order Details</h1>
<hr>
 
<div>
	<label>Supplier: </label> <?php echo $name; ?> 
</div>
<div>
	<label>Order Date: </label> <?php echo date('Y-m-d') ?>
</div>
<p>Hello we run out of stocks, please delivering the following items.</p>
<br> 
<table width="100%" class="table" style="text-align: left;">
	<thead>
		<tr >
			<th>Item Name</th>
			<th>Quantity</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($items): ?>
			<?php foreach($items as $item): ?>
				<tr>
					<td><?php echo $item->name ?></td>
					<td><?php echo 50 ?></td>
					<td><?php echo $item->description ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
</body>
</html>