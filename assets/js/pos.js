	$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	var totalAmountDue = 0;
	var transactionComplete = false;
	var currency = '₱';

	var dHeight = parseInt($(document).height());
 	
	dHeight = dHeight - 60;
	$(".header .box").css('height', dHeight + 'px');

	$("#cart-tbl").css('min-height', (dHeight - (113 + 231 + 25)) + 'px');
	$("#cart-tbl").css('max-height', (dHeight - (113 + 150 + 231)) + 'px');
	 
	var item_table = $("#item-table").DataTable({
		processing : true,
		serverSide : true,
		ajax : {
			url : base_url + 'items/data',
			type : 'POST'
		}
	});

	$("#item-table").on('click', 'tbody tr', function() {
		var id = $(this).find('td').eq(0).text();
		var name = $(this).find('td').eq(1).text();
		var stocks = $(this).find('td').eq(3).text();
		var price = $(this).find('td').eq(4).text();
		var description = $(this).find('td').eq(2).text();
  
		var quantity = 1;
	 	var subtotal = parseInt(quantity) * parseFloat($("#price").text().substring(1));
	 	totalAmountDue += parseFloat(subtotal);
		$("#cart tbody").append(
				'<tr>' +
					'<input name="id" type="hidden" value="'+ id +'">' +
					'<td>'+ name +'</td>' +
					'<td><input data-stocks="'+stocks+'" type="text" value="'+quantity+'" class="quantity-box"></td>' +
					'<td>'+ price +'</td>' +
		 
					'<td><span class="remove" style="font-size:12px;">Remove</span></td>' +
				'</tr>'
			);
		recount();
		$("payment").val('');
		$("change").val('');
	})

	$("#process-form").submit(function(e) {
		e.preventDefault();
		var row = $("#cart tbody tr").length;
		var sales = [];
		var customer_id = $("#customer-id").val();
		var total_amount = 0;

		var payment = $("#payment").val();
		var change = $("#change").val();
 		var vat = 0;
 		if (row) {

 			var totalAmountDue = parseFloat($("#amount-total").text().substring(1));
	 
			if (parseFloat(payment) >= parseFloat(totalAmountDue)) {
		 		
	 			for (i = 0; i < row; i++) {
					var r = $("#cart tbody tr").eq(i).find('td');
					var quantity = r.eq(1).find('input').val();
					var price = r.eq(2).text().substring(1);
					var arr = {
							id : $("#cart tbody tr").eq(i).find('input[name="id"]').val(), 
							quantity : quantity, 
							price : price,
							name : r.eq(0).text(),
							subtotal : parseFloat(price) * parseInt(quantity)
						};
					total_amount += parseFloat(price) * parseInt(quantity);
					sales.push(arr);
				}
			 
				// Receipt Items
				$("#r-items-table tbody").empty();
				$.each(sales, function(key, value) {
			 
					$("#r-items-table tbody").append(
							'<tr>' +
								'<td>'+value.id +'</td>' +
								'<td>'+value.name +'</td>' +
								'<td>'+currency+value.price +'</td>' +
								'<td>'+value.quantity+'</td>' +
								'<td>'+currency+value.subtotal+'</td>' +

							'</tr>'
						);
				});

				$.ajax({
					type : 'POST',
					data : {
						sales : sales
					},
					url : base_url + 'SalesController/insert',
					beforeSend : function() {
						$("#btn").button('loading');
					},
					success : function(data) { 
		 				transactionComplete = true;
		 				var total = parseFloat(total_amount);
		 				vat = parseFloat((total / 1.2) * 0.12);
		 				$("#payment-modal").modal('toggle');
						$("#loader").hide();
						//Transaction Summary 
						$("#summary-due").text(currency + total_amount);
						$("#summary-payment").text( currency + payment);
						$("#summary-change").text( currency + change);
						$("#summary-vat").text( currency + vat.toFixed(2) );
						$("#summary-total").text( currency + (vat + total).toFixed(2) )
						//Fill In Receipt
						$("#r-due").text(currency + total_amount);
						$("#r-payment").text( currency + parseFloat(payment));
						$("#r-change").text( currency + change);
						$("#r-cashier").text($("#user").text());
						$("#r-vat").text( currency + vat.toFixed(2) );
						$("#r-total-amount").text( currency + (vat + total).toFixed(2) )
						$("#r-id").text(data);
						totalAmountDue = 0;  
					 	$("#cart tbody").empty();
					 	$("#payment").val('');
					 	$("#change").val('');
					 	$("#amount-due").text('');
					 	$("#amount-vat").text('');
					 	$("#amount-total").text('');
					 	item_table.clear().draw();
					 	$("#btn").button('reset');
					 	
					}
				})
				return;
			}  
			
			return alert("Insufficient Amount");
		 
 			
 		}
 		
 		return alert('Please add some items');
 		
		
	})

	$("#discount-enter").click(function(e) {
		e.preventDefault();
		var discount = $("[name='discount']").val();
		if (parseInt(discount)) {
			$("#discount-container").show();
			$("#amount-discount").text(currency +discount);
			recount();
			$("#discount-modal").modal("toggle");
		}
	})

	$("#payment").keyup(function() {

		var payment = parseInt($(this).val());
		var cart = $("#cart tbody tr").length;
		if (cart) {
			var totalAmountDue = parseFloat($("#amount-total").text().substring(1));
			if (payment >= totalAmountDue) {
		 	
				return $("#change").val((payment - totalAmountDue).toFixed(2));
			} 

			return $("#change").val('Insufficient Amount');
		} 
		
		return $(this).val('');
		 

	})

	$("#cart").on('click', '.remove',function() {
		$(this).parents('tr').remove();
		recount();
	})

 	$("#cart").on('input', '.quantity-box', function() {

		var quantity = parseInt($(this).val());
		var currentStocks = $(this).data('stocks');

		if (isNaN(quantity))
			return quantity = 1;

		if (!isNaN(quantity) && quantity != 0) {
			if (quantity <= parseInt(currentStocks)) {
				var row = $(this).parents("tr");
				var priceCol = row.find('td').eq(2);
				var price = priceCol.text().substring(1);
				var subtotal = parseInt(quantity) * parseFloat(price);
				return recount();
			}
			
			alert('Not enough stocks only ' + currentStocks + ' remaining.');
			$(this).val(1);
			return recount();
		}

		
	})

	$("#cart").on("blur focusout", ".quantity-box", function() {

		if ($(this).val() == "" || isNaN(parseInt($(this).val()))) {
			$(this).val(1);
			return recount();
		}
	});
	$("#cart").on('focus', '.quantity-box', function() {
		$(this).val('');
	})


	function recount() {
		var row = $("#cart tbody tr").length;
		var total = 0;
		var vat = 0;
		var discount = parseInt($("#amount-discount").text().substring(1));
	 	
	 	if (isNaN(discount))
	 		discount = 0;

		for (i = 0; i < row; i++) {
			var r = $("#cart tbody tr").eq(i).find('td');
			var quantity = parseInt(r.eq(1).find('input').val());
			total += parseFloat(r.eq(2).text().substring(1)) * quantity;
		}
		vat = parseFloat((total / 1.2) * 0.12);

		$("#amount-vat").text(currency + vat.toFixed(2));
		$("#amount-due").text("₱" + (total).toFixed(2));
		$("#amount-discount").text(currency + discount.toFixed(2));
		$("#amount-total").text("₱" + (total + vat - discount).toFixed(2));
	}


	$("#print").click(function(){
		$("#receipt").print({
	        	globalStyles: true,
	        	mediaPrint: false,
	        	stylesheet: base_url + 'assets/receipt.css',
	        	noPrintSelector: ".no-print",
	        	iframe: true,
	        	append: null,
	        	prepend: null,
	        	manuallyCopyFormValues: true,
	        	deferred: $.Deferred(),
	        	timeout: 500,
	        	title: 'Receipt',
	        	doctype: '<!doctype html>'
		});
	})


})

 