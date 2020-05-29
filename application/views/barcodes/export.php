 
<div style="width: 800px;margin: auto;">
	<?php foreach ($barcodes as $barcode): ?>
		<div style=" " class="col">
			<div style="text-align: center;"><?php echo $barcode->item_name; ?></div>
			<?php echo $generator->getBarcode($barcode->barcode, $generator::TYPE_EAN_13, 2, 75) ?>
			<div style="text-align: center;"><?php echo $barcode->barcode; ?></div>
		</div>
	<?php endforeach; ?> 
</div>


<style type="text/css">
	
	.col {
		display: inline-block;
 		padding: 30px;
 		width: 190px;
	}
</style>

<script type="text/javascript">
	
	window.onload = function() {

		window.print();
	}
</script>
