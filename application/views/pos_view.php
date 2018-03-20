<!DOCTYPE html>
<html>
<head>
	<title>POS - Sales And Inventory Management System</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/pos_style.css') ?>">
	<script type="text/javascript" src="<?php echo base_url('assets/jquery.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/jquery-ui/jquery-ui.js') ?>"></script>
	<script type="text/javascript">
		$( document ).ready(function() {
			var list = {
						
					};
				list = [];
				list2 = ['alger','maki'];
				list3 = ['test', 'test'];
				list[0] = list2;
				list[1] = list3;
				console.log(list);

		    $("body").on('load',function autocomplete() {
				$("#item").autocomplete(function(){
					source: <?php echo $names ?>
				});
			});

			$("#item").on('change paste keyup propertychange ',function() {
				var item_name = $("#item").val();
				var item_info = $("#right");
	
				$.ajax ({
					type : 'POST',
					url : "<?php echo base_url(); ?>/get/item_info",
					data : {"item_name":item_name},
					datatype : 'text',
					success : function(result) {
						item_info.html(result);
					} 
				});
			});

			$("#add").on('click', function() {
				var item_name = $("#item").val();
				price = $("#price").text();
				quant = $("#quantity").val();
				total = $("#amount_due").text().substr(1);
				if( $("#item").val() !== "") {
					if (quant !== "" && !isNaN(quant) ) {
						$.ajax({
							type : 'POST',
							url : "<?php echo base_url()?>/get/cart",
							data : {"price" : price, "quantity" : quant,"item_name" : item_name, "total" : total},
							datatype : 'text',
							success : function(result){
								$('#tbl_head').after(result);
								$("#quantity").val(' ');
								$("#item").val(' ');	
							}
						});

					}else {
						alert('Quantity Is Required And Must Be Integer');
					}
				}else {
					alert('No Item Selected');
				}
			});

			$('#process').on('click',function () {
				var table = document.getElementById('cart');
				var x = document.getElementById('cart').rows.length;
				var y = document.getElementById('cart').rows[0].cells.length;
				var cart_items = [];
				var total = 0;				
				if (x === 1) {
					alert('Empty Cart!');
				}else {
					list = [];
					col_list = [];
					for (row = 1; row < x; row++){
						col_list = [];
						total += parseInt(table.rows[row].cells[4].innerHTML.substr(1));
						for (col = 0; col < y; col++){
							col_list.push(table.rows[row].cells[col].innerHTML);
						}
						list[row-1] = col_list;

					}
					var obj = Object.assign({}, list);
					cart_list = JSON.stringify(obj);
					console.log(cart_list);
					sessionStorage.setItem('cart',cart_list);
					sessionStorage.setItem('total',total);
					window.location = "<?php echo base_url() ?>/billing";
				}
			});
		});
	</script>
</head>
<body>
<header style="height: 60px; background: #2d2626; color: white;" class="">

<a href="<?php echo base_url('logout/out') ?>"><button style="float: right; margin-top: 6px; margin-right: 20px;" class="btn btn-primary btn-lg" >Sign Out</button></a>
	<div style="padding-left: 20px; padding-top: 2px;">
		<h2 style="margin: 0">POS Sales and Inventory System</h2>
		<p style="margin: 0;">By: Alger Makiputin</p>
	</div>
</header>
<div class="main">
	<div style="padding: 0 0px;">
		<div class="col-sm-6">
		<h3 style="float: left;">Customer Cart</h3>
		</div>
		<div class="col-sm-6">
		<?php $total_amount = ""; ?>
		<h3 id="total_amount">Total Amount Due <span id="amount_due"></span> </h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="cart">
		<div id="cart-tbl">
			<table class="table table-striped table-hover" id="cart">
				<tr id="tbl_head">
					<th>Item ID</th>
					<th>Item Name</th>
					<th>Quantity</th>
					<th>Price</th>
					<th>Sub Total</th>	
				</tr>
			</table>
		</div>
	</div>
	<div class="input">
		<div class="col-sm-6" id="left" >
			<form method="POST">
				<div class="col-sm-12">
				<div class="form-group">
					<label>Item Name</label>
					<input id="item" type="text" name="item_name" placeholder="Enter Item Name" class="form-control">
				</div>
				</div>
				<div class="col-sm-8">
				<div class="form-group">
					<label>Quantity</label>
					<input id="quantity" type="text" name="quantity" placeholder="Enter Quantity" class="form-control">
				</div>
				</div>
				<div class="col-sm-4" style="padding-top: 0px;">
					<input style="width: 100%; margin-bottom: 5px;" id="add" type="button" name="enter" class=" btn btn-info input-lg" value="ADD TO CART">
					<input style="width: 100%;" id="process" type="button" name="process" class=" btn btn-success input-lg" value="PROCESS">
				</div>
			</form>

		</div>
		<div class="col-sm-6" id="right">
			<label id="name">Item Name:</label><br>
			<label id="prc">Price:</label><br>
			<label id="description">Description:</label><br>
		</div>
	</div>
</div>
</body>
</html>
