<script type="text/javascript">
	
	var products = JSON.parse('<?php echo json_encode($this->db->select('items.id as data, items.name as value, prices.capital')->join('prices', 'prices.item_id = items.id')->get('items')->result()); ?>');

</script>
<input type="text" name="">